$original = $pwd;
$execution = Join-Path $PSScriptRoot '../';
Set-Location $execution;

docker-compose exec php drush cim

Set-Location $original;
