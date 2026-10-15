"""Read-only HTTP smoke test: python tests/check_routes.py [base URL]."""
import json
import sys
import urllib.error
import urllib.parse
import urllib.request
from html.parser import HTMLParser
from pathlib import Path

base = (sys.argv[1] if len(sys.argv) > 1 else 'http://127.0.0.1:8088/').rstrip('/') + '/'

class Links(HTMLParser):
    def __init__(self):
        super().__init__()
        self.paths = []
    def handle_starttag(self, tag, attrs):
        for key, value in attrs:
            if value and ((tag == 'a' and key == 'href') or (tag in ('script', 'link', 'img') and key in ('src', 'href'))):
                if value.startswith(base):
                    self.paths.append(value[len(base):])

queue = ['', 'login', 'register', 'forgot-password', 'reset-password', 'customer', 'admin']
visited = set()
results = []
while queue:
    path = queue.pop(0)
    if path in visited:
        continue
    visited.add(path)
    with urllib.request.urlopen(base + path, timeout=10) as response:
        payload = response.read()
        content_type = response.headers.get('Content-Type', '')
        body = payload.decode('utf-8') if not content_type.startswith('image/') else ''
        assert response.status == 200, (path, response.status)
        assert not any(x in body for x in ['exc-msg', 'Fatal error', 'Undefined property', 'Warning:']), path
        if 'text/html' in response.headers.get('Content-Type', ''):
            assert '</html>' in body, path
            parser = Links()
            parser.feed(body)
            queue.extend(parser.paths)
        results.append({'path': path or '/', 'status': 200})

for path, expected in [('missing-page',404),('plans/unknown',404),('customer/unknown',404),('admin/customers/unknown',404),('admin/no-page/no-detail',404),('database/schema.sql',403),('app/config/database.php',403),('.git/config',403)]:
    try:
        urllib.request.urlopen(base + path, timeout=10)
        raise AssertionError(f'{path}: expected {expected}')
    except urllib.error.HTTPError as error:
        assert error.code == expected, (path,error.code,expected)
        if expected == 404:
            assert b'This page could not be found' in error.read(), path
        results.append({'path':path,'status':expected})

query=urllib.parse.urlencode({'installment':'Jan 20, 2027','preview_method':'Bank Transfer'})
body=urllib.request.urlopen(base+'customer/payment/checkout?'+query).read().decode('utf-8')
assert 'Jan 20, 2027' in body and '<dd>Bank Transfer</dd>' in body
assert 'Not submitted' in body
output={'base_url':base,'passed':len(results)+1,'linked_pages_and_assets':len(visited),'checks':results,'checkout_selection':'passed'}
Path('docs/http-test-results.json').write_text(json.dumps(output,indent=2),encoding='utf-8')
print(f'PASS: {len(visited)} linked routes/assets, {len(results)-len(visited)} error/access checks, and checkout selection.')
