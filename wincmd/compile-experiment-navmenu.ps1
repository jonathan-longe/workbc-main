$original = $pwd;
$execution = Join-Path $PSScriptRoot '../src/web/experiments/navmenuhtml/';
Set-Location $execution;

sass navmenu.scss navmenu.css;

Set-Location $original;
