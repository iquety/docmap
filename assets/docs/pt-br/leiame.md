# Iquety Docmap

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
// instala o pacote
$ composer require ricardopedias/freep-docmap

// interpreta o diretório 'src-docs' e salva em 'docs'
$ vendor/bin/docmap -s src-docs -d docs
```

Para informações detalhadas, consulte o [Sumário da Documentação](indice.md).

## Características

- Feito para o PHP 8.0 ou superior;
- Codificado com boas práticas e máxima qualidade;
- Bem documentado e amigável para IDEs;
- Feito com TDD (Test Driven Development);
- Implementado com testes de unidade usando PHPUnit;
- Feito com :heart: &amp; :coffee:.

## Creditos

[Ricardo Pereira Dias](https://www.ricardopedias.com.br)
