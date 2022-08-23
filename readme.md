# Freep Docmap

![PHP Version](https://img.shields.io/badge/php-%5E8.0-blue)
![License](https://img.shields.io/badge/license-MIT-blue)
[![Codacy Badge](https://app.codacy.com/project/badge/Coverage/5a911e53f0cc421282d847d323f50203)](https://www.codacy.com/gh/ricardopedias/freep-console/dashboard?utm_source=github.com&utm_medium=referral&utm_content=ricardopedias/freep-console&utm_campaign=Badge_Coverage)
[![Codacy Badge](https://app.codacy.com/project/badge/Grade/5a911e53f0cc421282d847d323f50203)](https://www.codacy.com/gh/ricardopedias/freep-console/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=ricardopedias/freep-console&amp;utm_campaign=Badge_Grade)

[English](readme.md) | [Português](./docs/pt-br/leiame.md)
-- | --

## Sinopse

**Docmap** is a tool that generates a navigation menu in markdown-based documentation. It is very useful to facilitate navigability and add more professionalism to the documentation of repositories or libraries.

Below is an example of the menu that Docmap draws in documents:

[◂ Mono mono](readme.md) | [Back to index](readme.md) | [Nom monon ▸](readme.md)
-- | -- | --

To use, just install and run in Terminal:

```bash
// install the package
$ composer require ricardopedias/freep-docmap

// interpret 'src-docs' directory and save to 'docs'
$ vendor/bin/docmap -s src-docs -d docs
```

For detailed information, see [Documentation Summary](docs/en/index.md).

## Characteristics

- Made for PHP 8.0 or higher;
- Codified with best practices and maximum quality;
- Well documented and IDE friendly;
- Made with TDD (Test Driven Development);
- Implemented with unit tests using PHPUnit;
- Made with :heart: &amp; :coffee:.

## Credits

[Ricardo Pereira Dias](https://www.ricardopedias.com.br)
