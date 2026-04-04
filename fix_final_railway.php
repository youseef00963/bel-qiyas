<?php

file_put_contents('nixpacks.toml', <<<'EOT'
[phases.setup]
nixPkgs = ["php82", "php82Extensions.pdo", "php82Extensions.pdo_mysql", "php82Extensions.mbstring", "php82Extensions.tokenizer", "php82Extensions.xml", "php82Extensions.ctype", "php82Extensions.fileinfo", "php82Extensions.bcmath", "php82Extensions.curl", "php82Extensions.gd", "php82Packages.composer"]

[phases.install]
cmds = ["composer install --no-dev --optimize-autoloader"]

[phases.build]
cmds = [
    "php artisan config:cache",
    "php artisan route:cache",
    "php artisan view:cache"
]

[start]
cmd = "php artisan migrate --force && php -S 0.0.0.0:$PORT -t public"
EOT);
echo "✓ nixpacks.toml\n";

file_put_contents('railway.json', <<<'EOT'
{
  "$schema": "https://railway.app/railway.schema.json",
  "build": {
    "builder": "NIXPACKS"
  },
  "deploy": {
    "startCommand": "php artisan migrate --force && php -S 0.0.0.0:$PORT -t public"
  }
}
EOT);
echo "✓ railway.json\n";

echo "\n✅ تم! هلق:\n";
echo "git add .\n";
echo "git commit -m \"fix composer package name\"\n";
echo "git push\n";