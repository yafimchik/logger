# Install package

1. add package and repository at composer.json:

```json
{
  "require": {
    "jk/logger": "dev-master"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/yafimchik/logger"
    }
  ]
}
```

2. use `composer update`
