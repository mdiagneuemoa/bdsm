



<!DOCTYPE html>
<html lang="en" class=" is-copy-enabled is-u2f-enabled">
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# object: http://ogp.me/ns/object# article: http://ogp.me/ns/article# profile: http://ogp.me/ns/profile#">
    <meta charset='utf-8'>

    <link crossorigin="anonymous" href="https://assets-cdn.github.com/assets/frameworks-d05617edbd0684501ca011b9998eb456541d8156ca96d8ffcfb175827827f62c.css" integrity="sha256-0FYX7b0GhFAcoBG5mY60VlQdgVbKltj/z7F1gngn9iw=" media="all" rel="stylesheet" />
    <link crossorigin="anonymous" href="https://assets-cdn.github.com/assets/github-8a7b3d8f4db7e0cf07fa7b41a66e4292720ac2a2c3ce057b0e328d0a14dcb1ee.css" integrity="sha256-ins9j0234M8H+ntBpm5CknIKwqLDzgV7DjKNChTcse4=" media="all" rel="stylesheet" />
    
    
    <link crossorigin="anonymous" href="https://assets-cdn.github.com/assets/site-0996ced1a40a04be84d932b2c830830a2c87259cfb5c41c90ca7fee0c5979e9d.css" integrity="sha256-CZbO0aQKBL6E2TKyyDCDCiyHJZz7XEHJDKf+4MWXnp0=" media="all" rel="stylesheet" />
    

    <link as="script" href="https://assets-cdn.github.com/assets/frameworks-7162beea272a856d06e084945fd8026a47bbb9e7eb295d95b60ea82b26c27296.js" rel="preload" />
    
    <link as="script" href="https://assets-cdn.github.com/assets/github-b488c351cda2e01f720a508ce18a9571ef6e977c006bcb0a5d2324f2a4dcefb1.js" rel="preload" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta name="viewport" content="width=device-width">
    
    
    <title>jQueryAutocompletePlugin/jquery.autocomplete.pack.js at master · agarzola/jQueryAutocompletePlugin · GitHub</title>
    <link rel="search" type="application/opensearchdescription+xml" href="/opensearch.xml" title="GitHub">
    <link rel="fluid-icon" href="https://github.com/fluidicon.png" title="GitHub">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
    <meta property="fb:app_id" content="1401488693436528">

      <meta content="https://avatars3.githubusercontent.com/u/439649?v=3&amp;s=400" name="twitter:image:src" /><meta content="@github" name="twitter:site" /><meta content="summary" name="twitter:card" /><meta content="agarzola/jQueryAutocompletePlugin" name="twitter:title" /><meta content="jQueryAutocompletePlugin - Jörn Zaefferer’s (now deprecated) jQuery plugin, with tweaks." name="twitter:description" />
      <meta content="https://avatars3.githubusercontent.com/u/439649?v=3&amp;s=400" property="og:image" /><meta content="GitHub" property="og:site_name" /><meta content="object" property="og:type" /><meta content="agarzola/jQueryAutocompletePlugin" property="og:title" /><meta content="https://github.com/agarzola/jQueryAutocompletePlugin" property="og:url" /><meta content="jQueryAutocompletePlugin - Jörn Zaefferer’s (now deprecated) jQuery plugin, with tweaks." property="og:description" />
      <meta name="browser-stats-url" content="https://api.github.com/_private/browser/stats">
    <meta name="browser-errors-url" content="https://api.github.com/_private/browser/errors">
    <link rel="assets" href="https://assets-cdn.github.com/">
    
    <meta name="pjax-timeout" content="1000">
    

    <meta name="msapplication-TileImage" content="/windows-tile.png">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="selected-link" value="repo_source" data-pjax-transient>

    <meta name="google-site-verification" content="KT5gs8h0wvaagLKAVWq8bbeNwnZZK1r1XQysX3xurLU">
<meta name="google-site-verification" content="ZzhVyEFwb7w3e0-uOTltm8Jsck2F5StVihD0exw2fsA">
    <meta name="google-analytics" content="UA-3769691-2">

<meta content="collector.githubapp.com" name="octolytics-host" /><meta content="github" name="octolytics-app-id" /><meta content="D43482B4:300A:8503773:575FF65F" name="octolytics-dimension-request_id" />
<meta content="/&lt;user-name&gt;/&lt;repo-name&gt;/blob/show" data-pjax-transient="true" name="analytics-location" />



  <meta class="js-ga-set" name="dimension1" content="Logged Out">



        <meta name="hostname" content="github.com">
    <meta name="user-login" content="">

        <meta name="expected-hostname" content="github.com">
      <meta name="js-proxy-site-detection-payload" content="NzQyZWMxZDU4N2YyMjI0Zjk0MDdmMGJiYThjMTM5ZWU0MWEzYzJiMjYxNmJlMzg5MzAzNWU1YTY1ODE1N2JjOXx7InJlbW90ZV9hZGRyZXNzIjoiMjEyLjUyLjEzMC4xODAiLCJyZXF1ZXN0X2lkIjoiRDQzNDgyQjQ6MzAwQTo4NTAzNzczOjU3NUZGNjVGIiwidGltZXN0YW1wIjoxNDY1OTA2Nzg0fQ==">


      <link rel="mask-icon" href="https://assets-cdn.github.com/pinned-octocat.svg" color="#4078c0">
      <link rel="icon" type="image/x-icon" href="https://assets-cdn.github.com/favicon.ico">

    <meta name="html-safe-nonce" content="3b04cac22495ab9bd1cb11ffcae913f6971f1e6c">
    <meta content="abf5d47d28c03d8ad43bc5107086108ebbea42a5" name="form-nonce" />

    <meta http-equiv="x-pjax-version" content="0d991aedd39fd69967e97d3f953d7cc7">
    

      
  <meta name="description" content="jQueryAutocompletePlugin - Jörn Zaefferer’s (now deprecated) jQuery plugin, with tweaks.">
  <meta name="go-import" content="github.com/agarzola/jQueryAutocompletePlugin git https://github.com/agarzola/jQueryAutocompletePlugin.git">

  <meta content="439649" name="octolytics-dimension-user_id" /><meta content="agarzola" name="octolytics-dimension-user_login" /><meta content="1049298" name="octolytics-dimension-repository_id" /><meta content="agarzola/jQueryAutocompletePlugin" name="octolytics-dimension-repository_nwo" /><meta content="true" name="octolytics-dimension-repository_public" /><meta content="false" name="octolytics-dimension-repository_is_fork" /><meta content="1049298" name="octolytics-dimension-repository_network_root_id" /><meta content="agarzola/jQueryAutocompletePlugin" name="octolytics-dimension-repository_network_root_nwo" />
  <link href="https://github.com/agarzola/jQueryAutocompletePlugin/commits/master.atom" rel="alternate" title="Recent Commits to jQueryAutocompletePlugin:master" type="application/atom+xml">


      <link rel="canonical" href="https://github.com/agarzola/jQueryAutocompletePlugin/blob/master/jquery.autocomplete.pack.js" data-pjax-transient>
  </head>


  <body class="logged-out   env-production windows vis-public page-blob">
    <div id="js-pjax-loader-bar" class="pjax-loader-bar"></div>
    <a href="#start-of-content" tabindex="1" class="accessibility-aid js-skip-to-content">Skip to content</a>

    
    
    



          <header class="site-header js-details-container" role="banner">
  <div class="container-responsive">
    <a class="header-logo-invertocat" href="https://github.com/" aria-label="Homepage" data-ga-click="(Logged out) Header, go to homepage, icon:logo-wordmark">
      <svg aria-hidden="true" class="octicon octicon-mark-github" height="32" version="1.1" viewBox="0 0 16 16" width="32"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg>
    </a>

    <button class="btn-link right site-header-toggle js-details-target" type="button" aria-label="Toggle navigation">
      <svg aria-hidden="true" class="octicon octicon-three-bars" height="24" version="1.1" viewBox="0 0 12 16" width="18"><path d="M11.41 9H.59C0 9 0 8.59 0 8c0-.59 0-1 .59-1H11.4c.59 0 .59.41.59 1 0 .59 0 1-.59 1h.01zm0-4H.59C0 5 0 4.59 0 4c0-.59 0-1 .59-1H11.4c.59 0 .59.41.59 1 0 .59 0 1-.59 1h.01zM.59 11H11.4c.59 0 .59.41.59 1 0 .59 0 1-.59 1H.59C0 13 0 12.59 0 12c0-.59 0-1 .59-1z"></path></svg>
    </button>

    <div class="site-header-menu">
      <nav class="site-header-nav site-header-nav-main">
        <a href="/personal" class="js-selected-navigation-item nav-item nav-item-personal" data-ga-click="Header, click, Nav menu - item:personal" data-selected-links="/personal /personal">
          Personal
</a>        <a href="/open-source" class="js-selected-navigation-item nav-item nav-item-opensource" data-ga-click="Header, click, Nav menu - item:opensource" data-selected-links="/open-source /open-source">
          Open source
</a>        <a href="/business" class="js-selected-navigation-item nav-item nav-item-business" data-ga-click="Header, click, Nav menu - item:business" data-selected-links="/business /business/features /business/customers /business">
          Business
</a>        <a href="/explore" class="js-selected-navigation-item nav-item nav-item-explore" data-ga-click="Header, click, Nav menu - item:explore" data-selected-links="/explore /trending /trending/developers /integrations /integrations/feature/code /integrations/feature/collaborate /integrations/feature/ship /explore">
          Explore
</a>      </nav>

      <div class="site-header-actions">
            <a class="btn btn-primary site-header-actions-btn" href="/join?source=header-repo" data-ga-click="(Logged out) Header, clicked Sign up, text:sign-up">Sign up</a>
          <a class="btn site-header-actions-btn mr-2" href="/login?return_to=%2Fagarzola%2FjQueryAutocompletePlugin%2Fblob%2Fmaster%2Fjquery.autocomplete.pack.js" data-ga-click="(Logged out) Header, clicked Sign in, text:sign-in">Sign in</a>
      </div>

        <nav class="site-header-nav site-header-nav-secondary">
          <a class="nav-item" href="/pricing">Pricing</a>
          <a class="nav-item" href="/blog">Blog</a>
          <a class="nav-item" href="https://help.github.com">Support</a>
          <a class="nav-item header-search-link" href="https://github.com/search">Search GitHub</a>
              <div class="header-search scoped-search site-scoped-search js-site-search" role="search">
  <!-- </textarea> --><!-- '"` --><form accept-charset="UTF-8" action="/agarzola/jQueryAutocompletePlugin/search" class="js-site-search-form" data-scoped-search-url="/agarzola/jQueryAutocompletePlugin/search" data-unscoped-search-url="/search" method="get"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /></div>
    <label class="form-control header-search-wrapper js-chromeless-input-container">
      <div class="header-search-scope">This repository</div>
      <input type="text"
        class="form-control header-search-input js-site-search-focus js-site-search-field is-clearable"
        data-hotkey="s"
        name="q"
        placeholder="Search"
        aria-label="Search this repository"
        data-unscoped-placeholder="Search GitHub"
        data-scoped-placeholder="Search"
        tabindex="1"
        autocapitalize="off">
    </label>
</form></div>

        </nav>
    </div>
  </div>
</header>



    <div id="start-of-content" class="accessibility-aid"></div>

      <div id="js-flash-container">
</div>


    <div role="main" class="main-content">
        <div itemscope itemtype="http://schema.org/SoftwareSourceCode">
    <div id="js-repo-pjax-container" data-pjax-container>
      
<div class="pagehead repohead instapaper_ignore readability-menu experiment-repo-nav">
  <div class="container repohead-details-container">

    

<ul class="pagehead-actions">

  <li>
      <a href="/login?return_to=%2Fagarzola%2FjQueryAutocompletePlugin"
    class="btn btn-sm btn-with-count tooltipped tooltipped-n"
    aria-label="You must be signed in to watch a repository" rel="nofollow">
    <svg aria-hidden="true" class="octicon octicon-eye" height="16" version="1.1" viewBox="0 0 16 16" width="16"><path d="M8.06 2C3 2 0 8 0 8s3 6 8.06 6C13 14 16 8 16 8s-3-6-7.94-6zM8 12c-2.2 0-4-1.78-4-4 0-2.2 1.8-4 4-4 2.22 0 4 1.8 4 4 0 2.22-1.78 4-4 4zm2-4c0 1.11-.89 2-2 2-1.11 0-2-.89-2-2 0-1.11.89-2 2-2 1.11 0 2 .89 2 2z"></path></svg>
    Watch
  </a>
  <a class="social-count" href="/agarzola/jQueryAutocompletePlugin/watchers">
    25
  </a>

  </li>

  <li>
      <a href="/login?return_to=%2Fagarzola%2FjQueryAutocompletePlugin"
    class="btn btn-sm btn-with-count tooltipped tooltipped-n"
    aria-label="You must be signed in to star a repository" rel="nofollow">
    <svg aria-hidden="true" class="octicon octicon-star" height="16" version="1.1" viewBox="0 0 14 16" width="14"><path d="M14 6l-4.9-.64L7 1 4.9 5.36 0 6l3.6 3.26L2.67 14 7 11.67 11.33 14l-.93-4.74z"></path></svg>
    Star
  </a>

    <a class="social-count js-social-count" href="/agarzola/jQueryAutocompletePlugin/stargazers">
      269
    </a>

  </li>

  <li>
      <a href="/login?return_to=%2Fagarzola%2FjQueryAutocompletePlugin"
        class="btn btn-sm btn-with-count tooltipped tooltipped-n"
        aria-label="You must be signed in to fork a repository" rel="nofollow">
        <svg aria-hidden="true" class="octicon octicon-repo-forked" height="16" version="1.1" viewBox="0 0 10 16" width="10"><path d="M8 1a1.993 1.993 0 0 0-1 3.72V6L5 8 3 6V4.72A1.993 1.993 0 0 0 2 1a1.993 1.993 0 0 0-1 3.72V6.5l3 3v1.78A1.993 1.993 0 0 0 5 15a1.993 1.993 0 0 0 1-3.72V9.5l3-3V4.72A1.993 1.993 0 0 0 8 1zM2 4.2C1.34 4.2.8 3.65.8 3c0-.65.55-1.2 1.2-1.2.65 0 1.2.55 1.2 1.2 0 .65-.55 1.2-1.2 1.2zm3 10c-.66 0-1.2-.55-1.2-1.2 0-.65.55-1.2 1.2-1.2.65 0 1.2.55 1.2 1.2 0 .65-.55 1.2-1.2 1.2zm3-10c-.66 0-1.2-.55-1.2-1.2 0-.65.55-1.2 1.2-1.2.65 0 1.2.55 1.2 1.2 0 .65-.55 1.2-1.2 1.2z"></path></svg>
        Fork
      </a>

    <a href="/agarzola/jQueryAutocompletePlugin/network" class="social-count">
      141
    </a>
  </li>
</ul>

    <h1 class="public ">
  <svg aria-hidden="true" class="octicon octicon-repo" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path d="M4 9H3V8h1v1zm0-3H3v1h1V6zm0-2H3v1h1V4zm0-2H3v1h1V2zm8-1v12c0 .55-.45 1-1 1H6v2l-1.5-1.5L3 16v-2H1c-.55 0-1-.45-1-1V1c0-.55.45-1 1-1h10c.55 0 1 .45 1 1zm-1 10H1v2h2v-1h3v1h5v-2zm0-10H2v9h9V1z"></path></svg>
  <span class="author" itemprop="author"><a href="/agarzola" class="url fn" rel="author">agarzola</a></span><!--
--><span class="path-divider">/</span><!--
--><strong itemprop="name"><a href="/agarzola/jQueryAutocompletePlugin" data-pjax="#js-repo-pjax-container">jQueryAutocompletePlugin</a></strong>

</h1>

  </div>
  <div class="container">
    
<nav class="reponav js-repo-nav js-sidenav-container-pjax"
     itemscope
     itemtype="http://schema.org/BreadcrumbList"
     role="navigation"
     data-pjax="#js-repo-pjax-container">

  <span itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement">
    <a href="/agarzola/jQueryAutocompletePlugin" aria-selected="true" class="js-selected-navigation-item selected reponav-item" data-hotkey="g c" data-selected-links="repo_source repo_downloads repo_commits repo_releases repo_tags repo_branches /agarzola/jQueryAutocompletePlugin" itemprop="url">
      <svg aria-hidden="true" class="octicon octicon-code" height="16" version="1.1" viewBox="0 0 14 16" width="14"><path d="M9.5 3L8 4.5 11.5 8 8 11.5 9.5 13 14 8 9.5 3zm-5 0L0 8l4.5 5L6 11.5 2.5 8 6 4.5 4.5 3z"></path></svg>
      <span itemprop="name">Code</span>
      <meta itemprop="position" content="1">
</a>  </span>

    <span itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement">
      <a href="/agarzola/jQueryAutocompletePlugin/issues" class="js-selected-navigation-item reponav-item" data-hotkey="g i" data-selected-links="repo_issues repo_labels repo_milestones /agarzola/jQueryAutocompletePlugin/issues" itemprop="url">
        <svg aria-hidden="true" class="octicon octicon-issue-opened" height="16" version="1.1" viewBox="0 0 14 16" width="14"><path d="M7 2.3c3.14 0 5.7 2.56 5.7 5.7s-2.56 5.7-5.7 5.7A5.71 5.71 0 0 1 1.3 8c0-3.14 2.56-5.7 5.7-5.7zM7 1C3.14 1 0 4.14 0 8s3.14 7 7 7 7-3.14 7-7-3.14-7-7-7zm1 3H6v5h2V4zm0 6H6v2h2v-2z"></path></svg>
        <span itemprop="name">Issues</span>
        <span class="counter">14</span>
        <meta itemprop="position" content="2">
</a>    </span>

  <span itemscope itemtype="http://schema.org/ListItem" itemprop="itemListElement">
    <a href="/agarzola/jQueryAutocompletePlugin/pulls" class="js-selected-navigation-item reponav-item" data-hotkey="g p" data-selected-links="repo_pulls /agarzola/jQueryAutocompletePlugin/pulls" itemprop="url">
      <svg aria-hidden="true" class="octicon octicon-git-pull-request" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path d="M11 11.28V5c-.03-.78-.34-1.47-.94-2.06C9.46 2.35 8.78 2.03 8 2H7V0L4 3l3 3V4h1c.27.02.48.11.69.31.21.2.3.42.31.69v6.28A1.993 1.993 0 0 0 10 15a1.993 1.993 0 0 0 1-3.72zm-1 2.92c-.66 0-1.2-.55-1.2-1.2 0-.65.55-1.2 1.2-1.2.65 0 1.2.55 1.2 1.2 0 .65-.55 1.2-1.2 1.2zM4 3c0-1.11-.89-2-2-2a1.993 1.993 0 0 0-1 3.72v6.56A1.993 1.993 0 0 0 2 15a1.993 1.993 0 0 0 1-3.72V4.72c.59-.34 1-.98 1-1.72zm-.8 10c0 .66-.55 1.2-1.2 1.2-.65 0-1.2-.55-1.2-1.2 0-.65.55-1.2 1.2-1.2.65 0 1.2.55 1.2 1.2zM2 4.2C1.34 4.2.8 3.65.8 3c0-.65.55-1.2 1.2-1.2.65 0 1.2.55 1.2 1.2 0 .65-.55 1.2-1.2 1.2z"></path></svg>
      <span itemprop="name">Pull requests</span>
      <span class="counter">6</span>
      <meta itemprop="position" content="3">
</a>  </span>

    <a href="/agarzola/jQueryAutocompletePlugin/wiki" class="js-selected-navigation-item reponav-item" data-hotkey="g w" data-selected-links="repo_wiki /agarzola/jQueryAutocompletePlugin/wiki">
      <svg aria-hidden="true" class="octicon octicon-book" height="16" version="1.1" viewBox="0 0 16 16" width="16"><path d="M3 5h4v1H3V5zm0 3h4V7H3v1zm0 2h4V9H3v1zm11-5h-4v1h4V5zm0 2h-4v1h4V7zm0 2h-4v1h4V9zm2-6v9c0 .55-.45 1-1 1H9.5l-1 1-1-1H2c-.55 0-1-.45-1-1V3c0-.55.45-1 1-1h5.5l1 1 1-1H15c.55 0 1 .45 1 1zm-8 .5L7.5 3H2v9h6V3.5zm7-.5H9.5l-.5.5V12h6V3z"></path></svg>
      Wiki
</a>

  <a href="/agarzola/jQueryAutocompletePlugin/pulse" class="js-selected-navigation-item reponav-item" data-selected-links="pulse /agarzola/jQueryAutocompletePlugin/pulse">
    <svg aria-hidden="true" class="octicon octicon-pulse" height="16" version="1.1" viewBox="0 0 14 16" width="14"><path d="M11.5 8L8.8 5.4 6.6 8.5 5.5 1.6 2.38 8H0v2h3.6l.9-1.8.9 5.4L9 8.5l1.6 1.5H14V8z"></path></svg>
    Pulse
</a>
  <a href="/agarzola/jQueryAutocompletePlugin/graphs" class="js-selected-navigation-item reponav-item" data-selected-links="repo_graphs repo_contributors /agarzola/jQueryAutocompletePlugin/graphs">
    <svg aria-hidden="true" class="octicon octicon-graph" height="16" version="1.1" viewBox="0 0 16 16" width="16"><path d="M16 14v1H0V0h1v14h15zM5 13H3V8h2v5zm4 0H7V3h2v10zm4 0h-2V6h2v7z"></path></svg>
    Graphs
</a>

</nav>

  </div>
</div>

<div class="container new-discussion-timeline experiment-repo-nav">
  <div class="repository-content">

    

<a href="/agarzola/jQueryAutocompletePlugin/blob/ff730909d039c3e5be1807e169c7cd744e500a3b/jquery.autocomplete.pack.js" class="hidden js-permalink-shortcut" data-hotkey="y">Permalink</a>

<!-- blob contrib key: blob_contributors:v21:9c53bb0a880e0ed8ca58f645bf3e9cdd -->

<div class="file-navigation js-zeroclipboard-container">
  
<div class="select-menu branch-select-menu js-menu-container js-select-menu left">
  <button class="btn btn-sm select-menu-button js-menu-target css-truncate" data-hotkey="w"
    title="master"
    type="button" aria-label="Switch branches or tags" tabindex="0" aria-haspopup="true">
    <i>Branch:</i>
    <span class="js-select-button css-truncate-target">master</span>
  </button>

  <div class="select-menu-modal-holder js-menu-content js-navigation-container" data-pjax aria-hidden="true">

    <div class="select-menu-modal">
      <div class="select-menu-header">
        <svg aria-label="Close" class="octicon octicon-x js-menu-close" height="16" role="img" version="1.1" viewBox="0 0 12 16" width="12"><path d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg>
        <span class="select-menu-title">Switch branches/tags</span>
      </div>

      <div class="select-menu-filters">
        <div class="select-menu-text-filter">
          <input type="text" aria-label="Filter branches/tags" id="context-commitish-filter-field" class="form-control js-filterable-field js-navigation-enable" placeholder="Filter branches/tags">
        </div>
        <div class="select-menu-tabs">
          <ul>
            <li class="select-menu-tab">
              <a href="#" data-tab-filter="branches" data-filter-placeholder="Filter branches/tags" class="js-select-menu-tab" role="tab">Branches</a>
            </li>
            <li class="select-menu-tab">
              <a href="#" data-tab-filter="tags" data-filter-placeholder="Find a tag…" class="js-select-menu-tab" role="tab">Tags</a>
            </li>
          </ul>
        </div>
      </div>

      <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket" data-tab-filter="branches" role="menu">

        <div data-filterable-for="context-commitish-filter-field" data-filterable-type="substring">


            <a class="select-menu-item js-navigation-item js-navigation-open selected"
               href="/agarzola/jQueryAutocompletePlugin/blob/master/jquery.autocomplete.pack.js"
               data-name="master"
               data-skip-pjax="true"
               rel="nofollow">
              <svg aria-hidden="true" class="octicon octicon-check select-menu-item-icon" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path d="M12 5l-8 8-4-4 1.5-1.5L4 10l6.5-6.5z"></path></svg>
              <span class="select-menu-item-text css-truncate-target js-select-menu-filter-text" title="master">
                master
              </span>
            </a>
        </div>

          <div class="select-menu-no-results">Nothing to show</div>
      </div>

      <div class="select-menu-list select-menu-tab-bucket js-select-menu-tab-bucket" data-tab-filter="tags">
        <div data-filterable-for="context-commitish-filter-field" data-filterable-type="substring">


        </div>

        <div class="select-menu-no-results">Nothing to show</div>
      </div>

    </div>
  </div>
</div>

  <div class="btn-group right">
    <a href="/agarzola/jQueryAutocompletePlugin/find/master"
          class="js-pjax-capture-input btn btn-sm"
          data-pjax
          data-hotkey="t">
      Find file
    </a>
    <button aria-label="Copy file path to clipboard" class="js-zeroclipboard btn btn-sm zeroclipboard-button tooltipped tooltipped-s" data-copied-hint="Copied!" type="button">Copy path</button>
  </div>
  <div class="breadcrumb js-zeroclipboard-target">
    <span class="repo-root js-repo-root"><span class="js-path-segment"><a href="/agarzola/jQueryAutocompletePlugin"><span>jQueryAutocompletePlugin</span></a></span></span><span class="separator">/</span><strong class="final-path">jquery.autocomplete.pack.js</strong>
  </div>
</div>


  <div class="commit-tease">
      <span class="right">
        <a class="commit-tease-sha" href="/agarzola/jQueryAutocompletePlugin/commit/ff730909d039c3e5be1807e169c7cd744e500a3b" data-pjax>
          ff73090
        </a>
        <relative-time datetime="2013-05-22T14:15:59Z">May 22, 2013</relative-time>
      </span>
      <div>
        <img alt="" class="avatar" height="20" src="https://1.gravatar.com/avatar/952afccfb7f36af680542119104517c4?d=https%3A%2F%2Fassets-cdn.github.com%2Fimages%2Fgravatars%2Fgravatar-user-420.png&amp;r=x&amp;s=140" width="20" />
        <span class="user-mention">Alfonso</span>
          <a href="/agarzola/jQueryAutocompletePlugin/commit/ff730909d039c3e5be1807e169c7cd744e500a3b" class="message" data-pjax="true" title="Bump to v1.2.3. Correct typo from merge. Add .min &amp; .pack versions.

Updated README as well.">Bump to v1.2.3. Correct typo from merge. Add .min &amp; .pack versions.</a>
      </div>

    <div class="commit-tease-contributors">
      <button type="button" class="btn-link muted-link contributors-toggle" data-facebox="#blob_contributors_box">
        <strong>2</strong>
         contributors
      </button>
          <a class="avatar-link tooltipped tooltipped-s" aria-label="agarzola" href="/agarzola/jQueryAutocompletePlugin/commits/master/jquery.autocomplete.pack.js?author=agarzola"><img alt="@agarzola" class="avatar" height="20" src="https://avatars0.githubusercontent.com/u/439649?v=3&amp;s=40" width="20" /> </a>
    <a class="avatar-link tooltipped tooltipped-s" aria-label="agmcleod" href="/agarzola/jQueryAutocompletePlugin/commits/master/jquery.autocomplete.pack.js?author=agmcleod"><img alt="@agmcleod" class="avatar" height="20" src="https://avatars0.githubusercontent.com/u/113275?v=3&amp;s=40" width="20" /> </a>


    </div>

    <div id="blob_contributors_box" style="display:none">
      <h2 class="facebox-header" data-facebox-id="facebox-header">Users who have contributed to this file</h2>
      <ul class="facebox-user-list" data-facebox-id="facebox-description">
          <li class="facebox-user-list-item">
            <img alt="@agarzola" height="24" src="https://avatars2.githubusercontent.com/u/439649?v=3&amp;s=48" width="24" />
            <a href="/agarzola">agarzola</a>
          </li>
          <li class="facebox-user-list-item">
            <img alt="@agmcleod" height="24" src="https://avatars2.githubusercontent.com/u/113275?v=3&amp;s=48" width="24" />
            <a href="/agmcleod">agmcleod</a>
          </li>
      </ul>
    </div>
  </div>

<div class="file">
  <div class="file-header">
  <div class="file-actions">

    <div class="btn-group">
      <a href="/agarzola/jQueryAutocompletePlugin/raw/master/jquery.autocomplete.pack.js" class="btn btn-sm " id="raw-url">Raw</a>
        <a href="/agarzola/jQueryAutocompletePlugin/blame/master/jquery.autocomplete.pack.js" class="btn btn-sm js-update-url-with-hash">Blame</a>
      <a href="/agarzola/jQueryAutocompletePlugin/commits/master/jquery.autocomplete.pack.js" class="btn btn-sm " rel="nofollow">History</a>
    </div>

        <a class="btn-octicon tooltipped tooltipped-nw"
           href="https://windows.github.com"
           aria-label="Open this file in GitHub Desktop"
           data-ga-click="Repository, open with desktop, type:windows">
            <svg aria-hidden="true" class="octicon octicon-device-desktop" height="16" version="1.1" viewBox="0 0 16 16" width="16"><path d="M15 2H1c-.55 0-1 .45-1 1v9c0 .55.45 1 1 1h5.34c-.25.61-.86 1.39-2.34 2h8c-1.48-.61-2.09-1.39-2.34-2H15c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1zm0 9H1V3h14v8z"></path></svg>
        </a>

        <button type="button" class="btn-octicon disabled tooltipped tooltipped-nw"
          aria-label="You must be signed in to make or propose changes">
          <svg aria-hidden="true" class="octicon octicon-pencil" height="16" version="1.1" viewBox="0 0 14 16" width="14"><path d="M0 12v3h3l8-8-3-3-8 8zm3 2H1v-2h1v1h1v1zm10.3-9.3L12 6 9 3l1.3-1.3a.996.996 0 0 1 1.41 0l1.59 1.59c.39.39.39 1.02 0 1.41z"></path></svg>
        </button>
        <button type="button" class="btn-octicon btn-octicon-danger disabled tooltipped tooltipped-nw"
          aria-label="You must be signed in to make or propose changes">
          <svg aria-hidden="true" class="octicon octicon-trashcan" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path d="M11 2H9c0-.55-.45-1-1-1H5c-.55 0-1 .45-1 1H2c-.55 0-1 .45-1 1v1c0 .55.45 1 1 1v9c0 .55.45 1 1 1h7c.55 0 1-.45 1-1V5c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1zm-1 12H3V5h1v8h1V5h1v8h1V5h1v8h1V5h1v9zm1-10H2V3h9v1z"></path></svg>
        </button>
  </div>

  <div class="file-info">
      14 lines (14 sloc)
      <span class="file-info-divider"></span>
    8.8 KB
  </div>
</div>

  

  <div itemprop="text" class="blob-wrapper data type-javascript">
      <table class="highlight tab-size js-file-line-container" data-tab-size="8">
      <tr>
        <td id="L1" class="blob-num js-line-number" data-line-number="1"></td>
        <td id="LC1" class="blob-code blob-code-inner js-file-line"><span class="pl-c">/*</span></td>
      </tr>
      <tr>
        <td id="L2" class="blob-num js-line-number" data-line-number="2"></td>
        <td id="LC2" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> * jQuery Autocomplete plugin 1.2.2</span></td>
      </tr>
      <tr>
        <td id="L3" class="blob-num js-line-number" data-line-number="3"></td>
        <td id="LC3" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> *</span></td>
      </tr>
      <tr>
        <td id="L4" class="blob-num js-line-number" data-line-number="4"></td>
        <td id="LC4" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> * Copyright (c) 2009 Jörn Zaefferer</span></td>
      </tr>
      <tr>
        <td id="L5" class="blob-num js-line-number" data-line-number="5"></td>
        <td id="LC5" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> *</span></td>
      </tr>
      <tr>
        <td id="L6" class="blob-num js-line-number" data-line-number="6"></td>
        <td id="LC6" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> * Dual licensed under the MIT and GPL licenses:</span></td>
      </tr>
      <tr>
        <td id="L7" class="blob-num js-line-number" data-line-number="7"></td>
        <td id="LC7" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> *   http://www.opensource.org/licenses/mit-license.php</span></td>
      </tr>
      <tr>
        <td id="L8" class="blob-num js-line-number" data-line-number="8"></td>
        <td id="LC8" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> *   http://www.gnu.org/licenses/gpl.html</span></td>
      </tr>
      <tr>
        <td id="L9" class="blob-num js-line-number" data-line-number="9"></td>
        <td id="LC9" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> *</span></td>
      </tr>
      <tr>
        <td id="L10" class="blob-num js-line-number" data-line-number="10"></td>
        <td id="LC10" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> * With small modifications by Alfonso Gómez-Arzola.</span></td>
      </tr>
      <tr>
        <td id="L11" class="blob-num js-line-number" data-line-number="11"></td>
        <td id="LC11" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> * See changelog for details.</span></td>
      </tr>
      <tr>
        <td id="L12" class="blob-num js-line-number" data-line-number="12"></td>
        <td id="LC12" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> *</span></td>
      </tr>
      <tr>
        <td id="L13" class="blob-num js-line-number" data-line-number="13"></td>
        <td id="LC13" class="blob-code blob-code-inner js-file-line"><span class="pl-c"> */</span></td>
      </tr>
      <tr>
        <td id="L14" class="blob-num js-line-number" data-line-number="14"></td>
        <td id="LC14" class="blob-code blob-code-inner js-file-line">eval(function(p,a,c,k,e,r){e=function(c){return(c&lt;a?&#39;&#39;:e(parseInt(c/a)))+((c=c%a)&gt;35?String.fromCharCode(c+29):c.toString(36))};if(!&#39;&#39;.replace(/^/,String)){while(c--)r[e(c)]=k[c]||e(c);k=[function(e){return r[e]}];e=function(){return&#39;\\w+&#39;};c=1};while(c--)if(k[c])p=p.replace(new RegExp(&#39;\\b&#39;+e(c)+&#39;\\b&#39;,&#39;g&#39;),k[c]);return p}(&#39;;(5($){$.1n.1S({1l:5(28,3){6 1Z=P 28==&quot;2f&quot;;3=$.1S({},$.Q.2h,{18:1Z?28:E,7:1Z?E:28,1P:1Z?$.Q.2h.1P:10,O:3&amp;&amp;!3.1V?10:4Y,2q:&quot;4Q 4K.&quot;},3);3.2c=3.2c||5(e){a e};3.1Q=3.1Q||3.2w;a o.N(5(){2x $.Q(o,3)})},y:5(20){a o.1b(&quot;y&quot;,20)},1L:5(20){a o.1c(&quot;1L&quot;,[20])},2A:5(){a o.1c(&quot;2A&quot;)},2B:5(3){a o.1c(&quot;2B&quot;,[3])},2D:5(){a o.1c(&quot;2D&quot;)}});$.Q=5(g,3){6 H={3w:38,3t:40,3n:46,3m:9,3l:13,3k:27,3j:4B,3h:33,3e:34,3c:8};6 2b=E;4(3.1G!=E&amp;&amp;P 3.1G==&quot;5&quot;){2b=3.1G}6 $g=$(g).47(&quot;1l&quot;,&quot;54&quot;).T(3.36);6 1p;6 12=&quot;&quot;;6 1D=$.Q.35(3);6 1h=0;6 21;6 15={1B:p};6 h=$.Q.31(3,g,2S,15);6 2e;2T.2V.1v(&quot;3u&quot;)!=-1&amp;&amp;$(g.30).1b(&quot;4o.1l&quot;,5(){4(2e){2e=p;a p}});$g.1b((2T.2V.1v(&quot;3u&quot;)!=-1&amp;&amp;!\&#39;4r\&#39;2Q 4m?&quot;4A&quot;:&quot;42&quot;)+&quot;.1l&quot;,5(t){1h=1;21=t.3y;4n(t.3y){Y H.3w:4(h.I()){t.1r();h.3A()}j{Z(0,w)}W;Y H.3t:4(h.I()){t.1r();h.3B()}j{Z(0,w)}W;Y H.3h:4(h.I()){t.1r();h.3K()}j{Z(0,w)}W;Y H.3e:4(h.I()){t.1r();h.3P()}j{Z(0,w)}W;Y 3.1m&amp;&amp;$.1A(3.U)==&quot;,&quot;&amp;&amp;H.3j:Y H.3m:Y H.3l:4(2S()){t.1r();2e=w;a p}W;Y H.3k:h.16();W;4S:2o(1p);1p=2n(Z,3.1P);W}}).2m(5(){1h++}).50(5(){1h=0;4(!15.1B){3U()}}).3V(5(){4(3.2X){4(!h.I()){Z(0,w)}}j{4(1h++&gt;1&amp;&amp;!h.I()){Z(0,w)}}}).1b(&quot;1L&quot;,5(){6 1n=(24.f&gt;1)?24[1]:E;5 2K(q,7){6 y;4(7&amp;&amp;7.f){1j(6 i=0;i&lt;7.f;i++){4(7[i].y.M()==q.M()){y=7[i];W}}}4(P 1n==&quot;5&quot;)1n(y);j $g.1c(&quot;y&quot;,y&amp;&amp;[y.7,y.e])}$.N(17($g.L()),5(i,e){2g(e,2K,2K)})}).1b(&quot;2A&quot;,5(){1D.1O()}).1b(&quot;2B&quot;,5(){$.1S(w,3,24[1]);4(&quot;7&quot;2Q 24[1])1D.1I()}).1b(&quot;2D&quot;,5(){h.23();$g.23();$(g.30).23(&quot;.1l&quot;)});5 2S(){6 F=h.F();4(!F)a p;6 v=F.y;12=v;4(3.1m){6 A=17($g.L());4(A.f&gt;1){6 3Q=3.U.f;6 1F=$(g).1k().C;6 2p,1W=0;$.N(A,5(i,1y){1W+=1y.f;4(1F&lt;=1W){2p=i;a p}1W+=3Q});A[2p]=v;v=A.3M(3.U)}v+=3.U}$g.L(v);1x();$g.1c(&quot;y&quot;,[F.7,F.e]);a w}5 Z(4u,3D){4(21==H.3n){h.16();a}6 S=$g.L();4(!3D&amp;&amp;S==12)a;12=S;S=1E(S);4(S.f&gt;=3.2y){$g.T(3.2z);4(!3.26)S=S.M();2g(S,3z,1x)}j{22();h.16()}};5 17(e){4(!e)a[&quot;&quot;];4(!3.1m)a[$.1A(e)];a $.4k(e.2E(3.U),5(1y){a $.1A(e).f?$.1A(1y):E})}5 1E(e){4(!3.1m)a e;6 A=17(e);4(A.f==1)a A[0];6 1F=$(g).1k().C;4(1F==e.f){A=17(e)}j{A=17(e.2F(e.3p(1F),&quot;&quot;))}a A[A.f-1]}5 1U(q,2I){4(3.1U&amp;&amp;(1E($g.L()).M()==q.M())&amp;&amp;21!=H.3c){$g.L($g.L()+2I.3p(1E(12).f));$(g).1k(12.f,12.f+2I.f)}};5 3U(){2o(1p);1p=2n(1x,53)};5 1x(){6 4L=h.I();h.16();2o(1p);22();4(3.3i){$g.1L(5(y){4(!y){4(3.1m){6 A=17($g.L()).1s(0,-1);$g.L(A.3M(3.U)+(A.f?3.U:&quot;&quot;))}j{$g.L(&quot;&quot;);$g.1c(&quot;y&quot;,E)}}})}};5 3z(q,7){4(7&amp;&amp;7.f&amp;&amp;1h){22();h.3d(7,q);1U(q,7[0].e);h.2O()}j{1x()}};5 2g(z,1t,1G){4(!3.26)z=z.M();6 7=1D.37(z);4(7){4(7.f){1t(z,7)}j{6 R=3.19&amp;&amp;3.19(3.2q)||19(3.2q);1t(z,R)}}j 4((P 3.18==&quot;2f&quot;)&amp;&amp;(3.18.f&gt;0)){6 1u={48:+2x 52()};$.N(3.1u,5(3s,1R){1u[3s]=P 1R==&quot;5&quot;?1R():1R});$.4b({4d:&quot;4s&quot;,4y:&quot;1l&quot;+g.4X,2Y:3.2Y,18:3.18,7:$.1S({q:1E(z),44:3.O},1u),1t:5(7){6 R=3.19&amp;&amp;3.19(7)||19(7);1D.1w(z,R);1t(z,R)}})}j{h.2Z();4(2b!=E){2b()}j{1G(z)}}};5 19(7){6 R=[];6 2U=7.2E(&quot;\\n&quot;);1j(6 i=0;i&lt;2U.f;i++){6 B=$.1A(2U[i]);4(B){B=B.2E(&quot;|&quot;);R[R.f]={7:B,e:B[0],y:3.2d&amp;&amp;3.2d(B,B[0])||B[0]}}}a R};5 22(){$g.1z(3.2z)}};$.Q.2h={36:&quot;4t&quot;,32:&quot;4E&quot;,2z:&quot;4F&quot;,2y:1,1P:4N,26:p,1C:w,1T:p,1q:55,O:43,3i:p,1u:{},2R:w,2w:5(B){a B[0]},1Q:E,1U:p,G:0,1m:p,U:&quot; &quot;,39:w,2X:p,2c:5(e,z){a e.2F(2x 4a(&quot;(?![^&amp;;]+;)(?!&lt;[^&lt;&gt;]*)(&quot;+z.2F(/([\\^\\$\\(\\)\\[\\]\\{\\}\\*\\.\\+\\?\\|\\\\])/3a,&quot;\\\\$1&quot;)+&quot;)(?![^&lt;&gt;]*&gt;)(?![^&amp;;]+;)&quot;,&quot;3a&quot;),&quot;&lt;3b&gt;$1&lt;/3b&gt;&quot;)},1V:w,29:4l,2P:w};$.Q.35=5(3){6 7={};6 f=0;5 1C(s,2N){4(!3.26)s=s.M();6 i=s.1v(2N);4(3.1T==&quot;1y&quot;){i=s.M().1L(&quot;\\\\b&quot;+2N.M())}4(i==-1)a p;a i==0||3.1T};5 1w(q,e){4(f&gt;3.1q){1O()}4(!7[q]){f++}7[q]=e}5 1I(){4(!3.7)a p;6 1d={},3f=0;4(!3.18)3.1q=1;1d[&quot;&quot;]=[];1j(6 i=0,3g=3.7.f;i&lt;3g;i++){6 X=3.7[i];X=(P X==&quot;2f&quot;)?[X]:X;6 e=3.1Q(X,i+1,3.7.f);4(P(e)===\&#39;1H\&#39;||e===p)2M;6 1X=e.4D(0).M();4(!1d[1X])1d[1X]=[];6 B={e:e,7:X,y:3.2d&amp;&amp;3.2d(X)||e};1d[1X].2L(B);4(3f++&lt;3.O){1d[&quot;&quot;].2L(B)}};$.N(1d,5(i,e){3.1q++;1w(i,e)})}2n(1I,25);5 1O(){7={};f=0}a{1O:1O,1w:1w,1I:1I,37:5(q){4(!3.1q||!f)a E;4(!3.18&amp;&amp;3.1T){6 1f=[];1j(6 k 2Q 7){4(k.f&gt;0){6 c=7[k];$.N(c,5(i,x){4(1C(x.e,q)){1f.2L(x)}})}}a 1f}j 4(7[q]){a 7[q]}j 4(3.1C){1j(6 i=q.f-1;i&gt;=3.2y;i--){6 c=7[q.4R(0,i)];4(c){6 1f=[];$.N(c,5(i,x){4(1C(x.e,q)){1f[1f.f]=x}});a 1f}}}a E}}};$.Q.31=5(3,g,h,15){6 D={J:&quot;4Z&quot;};6 l,m=-1,7,z=&quot;&quot;,2J=w,u,r;5 3o(){4(!2J)a;u=$(&quot;&lt;3Y/&gt;&quot;).16().T(3.32).1g(&quot;3Z&quot;,&quot;41&quot;).2H(2G.3q).45(5(t){4($(o).3r(&quot;:I&quot;)){g.2m()}15.1B=p});r=$(&quot;&lt;3X/&gt;&quot;).2H(u).49(5(t){4(1a(t).2W&amp;&amp;1a(t).2W.4c()==\&#39;3v\&#39;){m=$(&quot;1J&quot;,r).1z(D.J).4e(1a(t));$(1a(t)).T(D.J)}}).3V(5(t){$(1a(t)).T(D.J);h();4(3.39)g.2m();a p}).4f(5(){15.1B=w}).4g(5(){15.1B=p});4(3.G&gt;0)u.1g(&quot;G&quot;,3.G);2J=p}5 1a(t){6 u=t.1a;4h(u&amp;&amp;u.4i!=&quot;3v&quot;)u=u.4j;4(!u)a[];a u}5 1e(1i){l.1s(m,m+1).1z(D.J);3x(1i);6 2C=l.1s(m,m+1).T(D.J);4(3.1V){6 K=0;l.1s(0,m).N(5(){K+=o.1K});4((K+2C[0].1K-r.1M())&gt;r[0].4p){r.1M(K+2C[0].1K-r.4q())}j 4(K&lt;r.1M()){r.1M(K)}}};5 3x(1i){4(3.2P||(!3.2P&amp;&amp;!((1i&lt;0&amp;&amp;m==0)||(1i&gt;0&amp;&amp;m==l.1o()-1)))){m+=1i;4(m&lt;0){m=l.1o()-1}j 4(m&gt;=l.1o()){m=0}}}5 3C(2v){a 3.O&amp;&amp;3.O&lt;2v?3.O:2v}5 3E(){r.3F();6 O=3C(7.f);1j(6 i=0;i&lt;O;i++){4(!7[i])2M;6 2u=3.2w(7[i].7,i+1,O,7[i].e,z);4(2u===p)2M;6 1J=$(&quot;&lt;1J/&gt;&quot;).4v(3.2c(2u,z)).T(i%2==0?&quot;4w&quot;:&quot;4x&quot;).2H(r)[0];$.7(1J,&quot;3G&quot;,7[i])}l=r.4z(&quot;1J&quot;);4(3.2R){l.1s(0,1).T(D.J);m=0}4($.1n.3H)r.3H()}a{3d:5(d,q){3o();7=d;z=q;3E()},3B:5(){1e(1)},3A:5(){1e(-1)},3K:5(){4(m!=0&amp;&amp;m-8&lt;0){1e(-m)}j{1e(-8)}},3P:5(){4(m!=l.1o()-1&amp;&amp;m+8&gt;l.1o()){1e(l.1o()-1-m)}j{1e(8)}},16:5(){u&amp;&amp;u.16();l&amp;&amp;l.1z(D.J);m=-1},I:5(){a u&amp;&amp;u.3r(&quot;:I&quot;)},4C:5(){a o.I()&amp;&amp;(l.3I(&quot;.&quot;+D.J)[0]||3.2R&amp;&amp;l[0])},2O:5(){6 K=$(g).K();u.1g({G:P 3.G==&quot;2f&quot;||3.G&gt;0?3.G:$(g).G(),3J:K.3J+g.1K,2t:K.2t}).2O();4(3.1V){r.1M(0);r.1g({3L:3.29,4G:\&#39;4H\&#39;});4(2T.2V.1v(&quot;4I&quot;)!=-1&amp;&amp;P 2G.3q.4J.3L===&quot;1H&quot;){6 2a=0;l.N(5(){2a+=o.1K});6 2s=2a&gt;3.29;r.1g(\&#39;4M\&#39;,2s?3.29:2a);4(!2s){l.G(r.G()-3N(l.1g(&quot;3O-2t&quot;))-3N(l.1g(&quot;3O-4O&quot;)))}}}},F:5(){6 F=l&amp;&amp;l.3I(&quot;.&quot;+D.J).1z(D.J);a F&amp;&amp;F.f&amp;&amp;$.7(F[0],&quot;3G&quot;)},2Z:5(){r&amp;&amp;r.3F()},23:5(){u&amp;&amp;u.4P()}}};$.1n.1k=5(C,11){4(C!==1H){a o.N(5(){4(o.2r){6 14=o.2r();4(11===1H||C==11){14.4T(&quot;2l&quot;,C);14.h()}j{14.4U(w);14.4V(&quot;2l&quot;,C);14.4W(&quot;2l&quot;,11);14.h()}}j 4(o.3R){o.3R(C,11)}j 4(o.1Y){o.1Y=C;o.3S=11}})}6 V=o[0];4(V.2r){6 2k=2G.1k.51(),3T=V.e,2j=&quot;&lt;-&gt;&quot;,2i=2k.3W.f;2k.3W=2j;6 1N=V.e.1v(2j);V.e=3T;o.1k(1N,1N+2i);a{C:1N,11:1N+2i}}j 4(V.1Y!==1H){a{C:V.1Y,11:V.3S}}}})(56);&#39;,62,317,&#39;|||options|if|function|var|data|||return||||value|length|input|select||else||listItems|active||this|false||list||event|element||true||result|term|words|row|start|CLASSES|null|selected|width|KEY|visible|ACTIVE|offset|val|toLowerCase|each|max|typeof|Autocompleter|parsed|currentValue|addClass|multipleSeparator|field|break|rawValue|case|onChange||end|previousValue||selRange|config|hide|trimWords|url|parse|target|bind|trigger|stMatchSets|moveSelect|csub|css|hasFocus|step|for|selection|autocomplete|multiple|fn|size|timeout|cacheLength|preventDefault|slice|success|extraParams|indexOf|add|hideResultsNow|word|removeClass|trim|mouseDownOnSelect|matchSubset|cache|lastWord|cursorAt|failure|undefined|populate|li|offsetHeight|search|scrollTop|caretAt|flush|delay|formatMatch|param|extend|matchContains|autoFill|scroll|progress|firstChar|selectionStart|isUrl|handler|lastKeyPressCode|stopLoading|unbind|arguments||matchCase||urlOrData|scrollHeight|listHeight|globalFailure|highlight|formatResult|blockSubmit|string|request|defaults|textLength|teststring|range|character|focus|setTimeout|clearTimeout|wordAt|noRecord|createTextRange|scrollbarsVisible|left|formatted|available|formatItem|new|minChars|loadingClass|flushCache|setOptions|activeItem|unautocomplete|split|replace|document|appendTo|sValue|needsInit|findValueCallback|push|continue|sub|show|scrollJumpPosition|in|selectFirst|selectCurrent|navigator|rows|userAgent|nodeName|clickFire|dataType|emptyList|form|Select|resultsClass|||Cache|inputClass|load||inputFocus|gi|strong|BACKSPACE|display|PAGEDOWN|nullData|ol|PAGEUP|mustMatch|COMMA|ESC|RETURN|TAB|DEL|init|substring|body|is|key|DOWN|Opera|LI|UP|movePosition|keyCode|receiveData|prev|next|limitNumberOfItems|skipPrevCheck|fillList|empty|ac_data|bgiframe|filter|top|pageUp|maxHeight|join|parseInt|padding|pageDown|seperator|setSelectionRange|selectionEnd|orig|hideResults|click|text|ul|div|position||absolute|keydown|1000|limit|hover||attr|timestamp|mouseover|RegExp|ajax|toUpperCase|mode|index|mousedown|mouseup|while|tagName|parentNode|map|180|window|switch|submit|clientHeight|innerHeight|KeyboardEvent|abort|ac_input|crap|html|ac_even|ac_odd|port|find|keypress|188|current|charAt|ac_results|ac_loading|overflow|auto|MSIE|style|Records|wasVisible|height|400|right|remove|No|substr|default|move|collapse|moveStart|moveEnd|name|150|ac_over|blur|createRange|Date|200|off|100|jQuery&#39;.split(&#39;|&#39;),0,{}))</td>
      </tr>
</table>

  </div>

</div>

<button type="button" data-facebox="#jump-to-line" data-facebox-class="linejump" data-hotkey="l" class="hidden">Jump to Line</button>
<div id="jump-to-line" style="display:none">
  <!-- </textarea> --><!-- '"` --><form accept-charset="UTF-8" action="" class="js-jump-to-line-form" method="get"><div style="margin:0;padding:0;display:inline"><input name="utf8" type="hidden" value="&#x2713;" /></div>
    <input class="form-control linejump-input js-jump-to-line-field" type="text" placeholder="Jump to line&hellip;" aria-label="Jump to line" autofocus>
    <button type="submit" class="btn">Go</button>
</form></div>

  </div>
  <div class="modal-backdrop"></div>
</div>


    </div>
  </div>

    </div>

        <div class="container site-footer-container">
  <div class="site-footer" role="contentinfo">
    <ul class="site-footer-links right">
        <li><a href="https://status.github.com/" data-ga-click="Footer, go to status, text:status">Status</a></li>
      <li><a href="https://developer.github.com" data-ga-click="Footer, go to api, text:api">API</a></li>
      <li><a href="https://training.github.com" data-ga-click="Footer, go to training, text:training">Training</a></li>
      <li><a href="https://shop.github.com" data-ga-click="Footer, go to shop, text:shop">Shop</a></li>
        <li><a href="https://github.com/blog" data-ga-click="Footer, go to blog, text:blog">Blog</a></li>
        <li><a href="https://github.com/about" data-ga-click="Footer, go to about, text:about">About</a></li>

    </ul>

    <a href="https://github.com" aria-label="Homepage" class="site-footer-mark" title="GitHub">
      <svg aria-hidden="true" class="octicon octicon-mark-github" height="24" version="1.1" viewBox="0 0 16 16" width="24"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.013 8.013 0 0 0 16 8c0-4.42-3.58-8-8-8z"></path></svg>
</a>
    <ul class="site-footer-links">
      <li>&copy; 2016 <span title="0.06281s from github-fe158-cp1-prd.iad.github.net">GitHub</span>, Inc.</li>
        <li><a href="https://github.com/site/terms" data-ga-click="Footer, go to terms, text:terms">Terms</a></li>
        <li><a href="https://github.com/site/privacy" data-ga-click="Footer, go to privacy, text:privacy">Privacy</a></li>
        <li><a href="https://github.com/security" data-ga-click="Footer, go to security, text:security">Security</a></li>
        <li><a href="https://github.com/contact" data-ga-click="Footer, go to contact, text:contact">Contact</a></li>
        <li><a href="https://help.github.com" data-ga-click="Footer, go to help, text:help">Help</a></li>
    </ul>
  </div>
</div>



    

    <div id="ajax-error-message" class="ajax-error-message flash flash-error">
      <svg aria-hidden="true" class="octicon octicon-alert" height="16" version="1.1" viewBox="0 0 16 16" width="16"><path d="M8.865 1.52c-.18-.31-.51-.5-.87-.5s-.69.19-.87.5L.275 13.5c-.18.31-.18.69 0 1 .19.31.52.5.87.5h13.7c.36 0 .69-.19.86-.5.17-.31.18-.69.01-1L8.865 1.52zM8.995 13h-2v-2h2v2zm0-3h-2V6h2v4z"></path></svg>
      <button type="button" class="flash-close js-flash-close js-ajax-error-dismiss" aria-label="Dismiss error">
        <svg aria-hidden="true" class="octicon octicon-x" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg>
      </button>
      Something went wrong with that request. Please try again.
    </div>


      
      <script crossorigin="anonymous" integrity="sha256-cWK+6icqhW0G4ISUX9gCake7uefrKV2Vtg6oKybCcpY=" src="https://assets-cdn.github.com/assets/frameworks-7162beea272a856d06e084945fd8026a47bbb9e7eb295d95b60ea82b26c27296.js"></script>
      <script async="async" crossorigin="anonymous" integrity="sha256-tIjDUc2i4B9yClCM4YqVce9ul3wAa8sKXSMk8qTc77E=" src="https://assets-cdn.github.com/assets/github-b488c351cda2e01f720a508ce18a9571ef6e977c006bcb0a5d2324f2a4dcefb1.js"></script>
      
      
      
      
      
      
    <div class="js-stale-session-flash stale-session-flash flash flash-warn flash-banner hidden">
      <svg aria-hidden="true" class="octicon octicon-alert" height="16" version="1.1" viewBox="0 0 16 16" width="16"><path d="M8.865 1.52c-.18-.31-.51-.5-.87-.5s-.69.19-.87.5L.275 13.5c-.18.31-.18.69 0 1 .19.31.52.5.87.5h13.7c.36 0 .69-.19.86-.5.17-.31.18-.69.01-1L8.865 1.52zM8.995 13h-2v-2h2v2zm0-3h-2V6h2v4z"></path></svg>
      <span class="signed-in-tab-flash">You signed in with another tab or window. <a href="">Reload</a> to refresh your session.</span>
      <span class="signed-out-tab-flash">You signed out in another tab or window. <a href="">Reload</a> to refresh your session.</span>
    </div>
    <div class="facebox" id="facebox" style="display:none;">
  <div class="facebox-popup">
    <div class="facebox-content" role="dialog" aria-labelledby="facebox-header" aria-describedby="facebox-description">
    </div>
    <button type="button" class="facebox-close js-facebox-close" aria-label="Close modal">
      <svg aria-hidden="true" class="octicon octicon-x" height="16" version="1.1" viewBox="0 0 12 16" width="12"><path d="M7.48 8l3.75 3.75-1.48 1.48L6 9.48l-3.75 3.75-1.48-1.48L4.52 8 .77 4.25l1.48-1.48L6 6.52l3.75-3.75 1.48 1.48z"></path></svg>
    </button>
  </div>
</div>

  </body>
</html>

