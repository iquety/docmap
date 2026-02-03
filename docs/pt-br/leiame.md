# Iquety Docmap

[![GitHub Release](https://img.shields.io/github/release/iquety/docmap.svg)](https://github.com/iquety/docmap/releases/latest)
![PHP Version](https://img.shields.io/badge/php-%5E8.3-blue)
![License](https://img.shields.io/badge/license-MIT-blue)
[![Codacy Grade](https://app.codacy.com/project/badge/Grade/5b22d15dcc5c4be59083809a0cfb7619)](https://www.codacy.com/gh/iquety/docmap/dashboard?utm_source=github.com&amp;utm_medium=referral&amp;utm_content=iquety/docmap&amp;utm_campaign=Badge_Grade)
[![Codacy Coverage](https://app.codacy.com/project/badge/Coverage/5b22d15dcc5c4be59083809a0cfb7619)](https://www.codacy.com/gh/iquety/docmap/dashboard?utm_source=github.com&utm_medium=referral&utm_content=iquety/docmap&utm_campaign=Badge_Coverage)

[English](../../readme.md) | [Português](leiame.md)
-- | --

## Sinopse

O **Docmap** é uma ferramenta que gera um menu de navegação em documentações baseadas em markdown. É muito útil para facilitar a navegabilidade e adicionar mais profissionalismo às documentações de repositórios ou bibliotecas.

```bash
composer require iquety/docmap
```

Abaixo, um exemplo do menu que o Docmap desenha nos documentos:

[◂ Mono mono](leiame.md) | [Back to index](leiame.md) | [Nom monon ▸](leiame.md)
-- | -- | --

Para usar, basta instalar e executar no Terminal:

```bash
// interpreta o diretório 'src-docs' e salva em 'docs'
vendor/bin/docmap -s src-docs -d docs
```

Para informações detalhadas, consulte o [Sumário da Documentação](indice.md).

## Características

- Codificado com boas práticas e máxima qualidade;
- Bem documentado e amigável para IDEs;
- Feito com TDD (Test Driven Development);
- Implementado com testes de unidade usando PHPUnit;
- Feito com :heart: &amp; :coffee:.

## Creditos

[Ricardo Pereira Dias](https://www.ricardopedias.com.br)
