<?php
 defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');
 $e=static function($v) { return htmlspecialchars((string)$v,ENT_QUOTES,'UTF-8'); };
 $url=static function($path='') use($e) { return $e(site_url($path)); };
 $route=$area==='public' ? ($page==='home' ? '' : $page) : "$area/$page";
 $workspaceLabel=['public'=>'Project overview','customer'=>'Planholder portal','admin'=>'Administrator portal'][$area];
 $navPages=$area==='public' ? ['home'=>'Overview','about'=>'About the Project','plans'=>'Memorial Plans','faq'=>'Frequently Asked Questions','contact'=>'Contact & Support'] : $map[$area];
 unset($navPages['beneficiaries'], $navPages['services'], $navPages['refunds']);
 $icons=['home'=>'▦','dashboard'=>'▦','about'=>'ⓘ','plans'=>'▣','faq'=>'?','contact'=>'✉','profile'=>'◎','contracts'=>'▤','billing'=>'▦','payment'=>'₱','history'=>'◷','receipts'=>'▧','documents'=>'▱','support'=>'✉','notifications'=>'♧','customers'=>'♙','payments'=>'₱','methods'=>'▰','inquiries'=>'✉','users'=>'♙','reports'=>'▥'];
?><!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?= $e($title) ?> · St. Peter Project</title><link rel="icon" href="data:,"><link rel="stylesheet" href="<?= $url('assets/css/memorial.css') ?>"><link rel="stylesheet" href="<?= $url('assets/css/st-peter-dashboard.css') ?>"><link rel="stylesheet" href="<?= $url('assets/css/wireframe.css') ?>"><script src="<?= $url('assets/js/memorial.js') ?>" defer></script></head>
<body class="<?= $e($area) ?> <?= $area==='public' ? 'public-site' : 'dashboard-app' ?>">
<a class="skip-link" href="#main">Skip to content</a>
<?php if($area==='public'): ?>
<header class="public-header"><a class="brand" href="<?= $url() ?>" aria-label="St. Peter project home"><img class="official-logo" src="<?= $url('assets/images/st-peter-logo.png') ?>" alt="St. Peter Life Plan · Chapels"></a><button class="menu-toggle" aria-controls="public-nav" aria-expanded="false">Menu</button><nav id="public-nav" class="public-nav" aria-label="Main navigation"><?php foreach(['home'=>'Home','about'=>'About','plans'=>'Plans','faq'=>'FAQ','contact'=>'Contact'] as $key=>$label): ?><a <?= $page===$key ? 'aria-current="page"' : '' ?> href="<?= $url($key==='home' ? '' : $key) ?>"><?= $e($label) ?></a><?php endforeach ?><a class="button secondary small" href="<?= $url('login') ?>">Login</a><a class="button small" href="<?= $url('register') ?>">Register</a></nav></header>
<div class="public-demo">College project demonstration · St. Peter-inspired design · Sample plans and prices · No real payments</div>
<main id="main"><?php if($page!=='home'): ?><div class="container breadcrumb"><a href="<?= $url() ?>">Home</a> / <?php if($detail): ?><a href="<?= $url('plans') ?>">Plans</a> / <?php endif ?><?= $e($title) ?></div><?php endif ?><?php require __DIR__.'/public.php'; ?></main>
<footer><div class="container footer-grid"><div><img class="official-logo" src="<?= $url('assets/images/st-peter-logo.png') ?>" alt="St. Peter Life Plan · Chapels"><p class="muted">Memorial Plan Management and Online Payment System<br>Independent college project, not an official St. Peter service.</p></div><div><strong>Explore the project</strong><p><a href="<?= $url('plans') ?>">Memorial Plans</a><br><a href="<?= $url('faq') ?>">Frequently Asked Questions</a><br><a href="<?= $url('contact') ?>">Contact & Support</a></p></div><div><a href="<?= $url('customer') ?>">Customer demo →</a><br><a href="<?= $url('admin') ?>">Administrator demo →</a><br><a href="https://stpeter.com.ph/" target="_blank" rel="noopener noreferrer">Official St. Peter website ↗</a></div></div></footer>
<?php else: ?>
<aside class="sidebar" id="app-nav">
 <a class="brand" href="<?= $url() ?>" aria-label="St. Peter project overview"><img class="official-logo" src="<?= $url('assets/images/st-peter-logo.png') ?>" alt="St. Peter Life Plan · Chapels"></a>
 <div class="workspace-tag"><span class="workspace-dot"></span><?= $e($workspaceLabel) ?></div>
 <p class="nav-caption">MAIN MENU</p>
 <nav aria-label="<?= $area==='public' ? 'Main navigation' : 'Portal navigation' ?>">
 <?php foreach($navPages as $key=>$label): $path=$area==='public' ? ($key==='home' ? '' : $key) : "$area/$key"; ?>
 <a class="<?= $area==='customer' && $key==='contracts' ? 'nav-subitem' : '' ?>" <?= $page===$key ? 'aria-current="page"' : '' ?> href="<?= $url($path) ?>"><span class="nav-icon" aria-hidden="true"><?= $e($icons[$key] ?? '▦') ?></span><?= $e($label) ?></a>
 <?php endforeach ?>
 </nav>
 <p class="nav-caption workspace-caption">DEMO WORKSPACES</p>
 <nav aria-label="Workspace selection"><a href="<?= $url('customer') ?>"><span class="nav-icon" aria-hidden="true">◎</span>Customer demo</a><a href="<?= $url('admin') ?>"><span class="nav-icon" aria-hidden="true">▥</span>Administrator demo</a><?php if($area==='public'): ?><a href="<?= $url('login') ?>"><span class="nav-icon" aria-hidden="true">↗</span>Account access</a><?php endif ?></nav>
 <div class="sidebar-note"><strong>Checking 1</strong><small>System Design & Project Setup</small><span>College project demonstration</span></div>
 <?php if($area!=='public'): ?><a class="back-site" href="<?= $url() ?>">← Project overview</a><?php endif ?>
</aside>
<div class="workspace">
 <header class="portal-header"><div class="header-context"><button class="menu-toggle" aria-controls="app-nav" aria-expanded="false">Menu</button><div><strong>Memorial Plan Management</strong><small>Online Payment System</small></div></div><div class="header-tools"><span class="preview-chip">DEMO PREVIEW</span><div class="identity"><span class="avatar"><?= $area==='admin' ? 'AD' : ($area==='customer' ? 'JC' : 'SP') ?></span><span><?= $area==='admin' ? 'Demo Administrator' : ($area==='customer' ? 'Juan Dela Cruz' : 'Project Visitor') ?><small><?= $e($workspaceLabel) ?></small></span></div></div></header>
 <main id="main" class="portal-main <?= $area==='public' ? 'public-main' : '' ?>">
 <div class="demo-banner"><strong>COLLEGE PROJECT DEMO</strong> Inspired by St. Peter's visual identity. Not an official St. Peter service. Sample records only; no authentication, saved changes, or real payments.</div>
 <div class="breadcrumb"><a href="<?= $url($area==='public' ? '' : "$area/dashboard") ?>"><?= $e($workspaceLabel) ?></a> / <?= $e($title) ?><?= $detail ? ' / '.$e(ucwords(str_replace('-',' ',$detail))) : '' ?></div>
 <?php if($area!=='public'): ?><div class="page-heading"><div><span class="eyebrow"><?= $area==='admin' ? 'OPERATIONS DASHBOARD' : 'YOUR PLANHOLDER WORKSPACE' ?></span><h1><?= $page==='dashboard' ? ($area==='admin' ? 'Administrator Dashboard' : 'Welcome back, Juan!') : $e($title) ?></h1><p><?= $page==='dashboard' ? 'Track plans, installments, and activity in one place.' : 'Review sample records and explore the planned workflow.' ?></p></div><span class="date-chip">Checking 1 · Sample data</span></div><?php endif ?>
 <?php if($area==='admin' && !$detail): $actions=['customers'=>['add','Add Customer'],'plans'=>['add','Add Plan'],'contracts'=>['create','Create Contract'],'billing'=>['create','Create Payment Schedule'],'payments'=>['record','Record Payment'],'methods'=>['add','Add Payment Method'],'documents'=>['upload','Upload Document'],'users'=>['add','Add User']]; if(isset($actions[$page])): ?><div class="management-actions"><a class="button small" href="<?= $url("admin/$page/".$actions[$page][0]) ?>">+ <?= $e($actions[$page][1]) ?></a></div><?php endif; endif ?>
 <?php require __DIR__.'/portal.php'; ?>
 </main>
 <footer class="portal-footer"><span>St. Peter-inspired college project · Demonstration only</span><a href="https://stpeter.com.ph/" target="_blank" rel="noopener noreferrer">Official St. Peter website ↗</a></footer>
</div><?php endif ?></body></html>
