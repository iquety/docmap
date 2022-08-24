# Languages

[◂ How to use](01-how-to-use.md) | [Documentation index](index.md) | [Using replacement tags ▸](03-tags-replacement.md)
-- | -- | --

## Choosing a language

Currently, Docmap supports two languages: English and Portuguese.

```bash
# especificando o idioma pt-br

$ vendor/bin/docmap -s src-docs -d docs -l pt-br
```

When specifying a language, in addition to translating the navigation menus, the name of the index file also changes.

That is, if the language is set to 'pt-br', the documentation must contain a file called 'indice.md'.

If the language is not specified, or if it is set to 'en', the documentation must contain a file called 'index.md'.

Language | Summary file name
-- | --
en | index.md
pt-br | indice.md

[◂ How to use](01-how-to-use.md) | [Documentation index](index.md) | [Using replacement tags ▸](03-tags-replacement.md)
-- | -- | --
