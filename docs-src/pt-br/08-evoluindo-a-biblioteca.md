# Evoluindo a biblioteca

--page-nav--

## 1. Infraestrutura

Se o [Docker](https://www.docker.com/) estiver instalado no computador, não será
necessário ter o Composer ou PHP instalados.

Para usar o Composer e as bibliotecas de qualidade de código, use o script `./composer`,
localizado na raiz deste repositório. Este script é, na verdade, uma ponte para
todos os comandos do Composer, executando-os através do Docker.

## 2. Controle de qualidade

### 2.1. Ferramentas

Para o desenvolvimento, foram utilizadas ferramentas para testes de unidade e
análise estática. Todas configuradas no nível máximo de exigência.

São as seguintes ferramentas:

- [PHP Unit](https://phpunit.de)
- [PHP Stan](https://phpstan.org)
- [PHP Code Sniffer](https://github.com/squizlabs/PHP_CodeSniffer)
- [PHP MD](https://phpmd.org)
- [Super Linter](https://github.com/super-linter/super-linter)

### 2.2. Análise estática

Para fazer a análise do código implementado e colher feedback das ferramentas, use:

```bash
./composer analyse
```

O comando acima executa todas as ferramentas de análise estática ao mesmo tempo.
Caso seja necessário, é possível executá-las de forma individual:

```bash
# Executa a análise da documentação
./composer lint
```

```bash
# Executa o Mess Detector
./composer mess
```

```bash
# Executa o PHP Static Analizer
./composer stan
```

```bash
# Execute o Code Sniffer
./composer psr
```

### 2.3. Testes automatizados

Para executar os testes de unidade, use:

```bash
./composer test
```

## 3. Lançamento de Releases

A biblioteca `iquety/docmap` é usada por todas as bibliotecas do framework. Em alguns casos ocorre a referência cruzada, como por exemplo o `iquety/console` que depende do `iquety/docmap` que por sua vez depende o `iquety/console`.

Por esse motivo, cada vez que um novo Release do `iquety/docmap` for publicado, será necessária atenção para as seguintes atualizações nos arquivos `composer.json` dos seguintes pacotes.

| Pacote | Atualização |
|:--     |:--          |
| iquety/console | "require-dev": { "iquety/docmap": "dev-main" } |

```bash
composer docmap
```

--page-nav--

