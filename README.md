## Mysql SCRIPT
```
CREATE TABLE produtos (  
  id_produtos INT PRIMARY KEY AUTO_INCREMENT,  
  nome VARCHAR(255) NOT NULL,  
  descricao TEXT,
  preco_unit DECIMAL(10,2) NOT NULL,
  quantidade_estoque INT NOT NULL  
); 
 
CREATE TABLE clientes (
  id_clientes INT PRIMARY KEY AUTO_INCREMENT,  
  nome VARCHAR(255) NOT NULL,  
  email VARCHAR(255) UNIQUE,  
  telefone VARCHAR(20) NOT NULL,  
  data_cadastro DATETIME,  
  ativo BOOLEAN 
);
 
CREATE TABLE vendedores ( 
  id_vendedores INT PRIMARY KEY AUTO_INCREMENT,  
  nome VARCHAR(255) NOT NULL,  
  cpf VARCHAR(15) NOT NULL,  
  telefone VARCHAR(15) NOT NULL  
);  
 
CREATE TABLE forma_pagamento ( 
  id_pagamentos INT PRIMARY KEY AUTO_INCREMENT,  
  descricao VARCHAR(255) NOT NULL 
); 
 
CREATE TABLE pedidos (
  id_pedidos INT PRIMARY KEY AUTO_INCREMENT,
  id_cliente INT NOT NULL, 
  id_forma_pagamento INT NOT NULL, 
  id_vendedor INT NOT NULL,  
  data_pedido DATETIME,  
  valor_total DECIMAL(12,2),
  status_pedido ENUM('ativo', 'cancelado') DEFAULT 'ativo',  
  FOREIGN KEY (id_cliente) REFERENCES clientes(id_clientes), 
  FOREIGN KEY (id_forma_pagamento) REFERENCES forma_pagamento(id_pagamentos),
  FOREIGN KEY (id_vendedor) REFERENCES vendedores(id_vendedores) 
); 
 
CREATE TABLE itens_pedido ( 
  id INT PRIMARY KEY AUTO_INCREMENT, 
  id_pedido INT NOT NULL, 
  id_produto INT NOT NULL, 
  quantidade INT NOT NULL,  
  preco_unit DECIMAL(10,2),  
  subtotal DECIMAL(12,2) GENERATED ALWAYS AS (quantidade * preco_unit) STORED, 
  FOREIGN KEY (id_pedido) REFERENCES pedidos(id_pedidos) ON DELETE CASCADE, 
  FOREIGN KEY (id_produto) REFERENCES produtos(id_produtos) 
);  
 
DELIMITER $$ 

CREATE PROCEDURE sp_inserir_item_pedido ( IN p_id_pedido INT, IN p_id_produto INT, IN p_quantidade INT ) BEGIN DECLARE v_preco_unit DECIMAL(10,2); 

SELECT preco_unit INTO v_preco_unit 
FROM produtos 
WHERE id_produtos = p_id_produto; 
 
INSERT INTO itens_pedido ( 
    id_pedido, id_produto, quantidade, preco_unit 
) VALUES ( 
    p_id_pedido, p_id_produto, p_quantidade, v_preco_unit 
);   

END$$ 
DELIMITER ; 

INSERT INTO produtos (nome, descricao, preco_unit, quantidade_estoque) 
VALUES
  ('Detergente Líquido Ypê', 'Para lavar louças, fragrância neutra, 500ml', 2.99, 100),
  ('Sabão em Pó Omo Lavagem Perfeita', 'Para roupas, 1,6kg', 19.90, 60),
  ('Desinfetante Pinho Sol', 'Aroma pinho, 1L', 6.50, 80),
  ('Água Sanitária Qboa', 'Desinfecção geral, 2L', 4.75, 90),
  ('Lustra Móveis Poliflor', 'Limpeza e brilho para móveis, 200ml', 8.99, 50),
  ('Multiuso Veja Lavanda', 'Limpeza geral perfumada, 500ml', 7.50, 75),
  ('Desengordurante Veja Gold', 'Para cozinha, ação rápida, 500ml', 9.90, 70),
  ('Limpa Vidros Veja', 'Sem manchas, 500ml', 6.99, 65),
  ('Pano Multiuso Scotch-Brite', 'Pacote com 5 unidades', 10.00, 85),
  ('Esponja de Aço Assolan', 'Para panelas, pacote com 8 unidades', 3.99, 120);
 
INSERT INTO clientes (nome, email, telefone, data_cadastro, ativo) 
VALUES
  ('Roberta Lima', 'roberta.lima@gmail.com', '11999887766', NOW(), TRUE),
  ('Marcos Tavares', 'marcos.t@gmail.com', '11987654321', NOW(), TRUE),
  ('Luciana Alves', 'luciana.alves@gmail.com', '11981234455', NOW(), TRUE),
  ('Renato Costa', 'renato.costa@gmail.com', '11989997711', NOW(), TRUE),
  ('Beatriz Fernandes', 'beatriz.fernandes@gmail.com', '11981112233', NOW(), TRUE),
  ('Ricardo Mendes', 'ricardo.mendes@gmail.com', '11990001122', NOW(), TRUE),
  ('Carla Borges', 'carla.borges@gmail.com', '11987776655', NOW(), TRUE),
  ('Juliano Rocha', 'juliano.rocha@gmail.com', '11980008877', NOW(), TRUE),
  ('Amanda Ribeiro', 'amanda.ribeiro@gmail.com', '11982223344', NOW(), TRUE),
  ('Gustavo Martins', 'gustavo.martins@gmail.com', '11983334455', NOW(), TRUE);
 
INSERT INTO forma_pagamento (descricao) 
VALUES
  ('Cartão de Crédito'),
  ('Cartão de Débito'),
  ('Boleto Bancário'),
  ('Pix'),
  ('Transferência Bancária'),
  ('Dinheiro'),
  ('PayPal'),
  ('Mercado Pago'),
  ('PicPay'),
  ('Vale Compras');

INSERT INTO vendedores (nome, cpf, telefone)
VALUES 
  ('Carlos Silva', '123.456.789-00', '(11) 91234-5678'),
  ('Ana Oliveira', '234.567.890-11', '(21) 98765-4321'),
  ('João Pereira', '345.678.901-22', '(31) 99876-5432'),
  ('Mariana Souza', '456.789.012-33', '(41) 98765-1234'),
  ('Lucas Andrade', '567.890.123-44', '(51) 97654-3210');

INSERT INTO pedidos (id_cliente, id_forma_pagamento, data_pedido, valor_total, status_pedido, id_vendedor) 
VALUES
  (1, 4, NOW(), 29.99, 'ativo',1),
  (2, 1, NOW(), 54.90, 'ativo',2),
  (3, 2, NOW(), 25.75, 'ativo',3),
  (4, 6, NOW(), 15.48, 'cancelado',4),
  (5, 3, NOW(), 39.00, 'ativo',5),
  (6, 5, NOW(), 78.30, 'ativo',1),
  (7, 1, NOW(), 33.47, 'ativo',2),
  (8, 2, NOW(), 62.90, 'ativo',3),
  (9, 4, NOW(), 44.20, 'ativo',4),
  (10, 6, NOW(), 19.90, 'cancelado',5);

INSERT INTO itens_pedido (id_pedido, id_produto, quantidade, preco_unit) 
VALUES
  (1, 1, 3, 2.99), 
  (1, 3, 2, 6.50),  
  (2, 2, 2, 19.90),  
  (2, 6, 2, 7.50),   
  (3, 4, 1, 4.75),
  (3, 10, 3, 3.99),
  (4, 1, 2, 2.99),
  (5, 5, 2, 8.99),
  (6, 2, 3, 19.90),
  (6, 6, 1, 7.50);
```


Dompdf
======

[![Build Status](https://github.com/dompdf/dompdf/actions/workflows/test.yml/badge.svg)](https://github.com/dompdf/dompdf/actions/workflows/test.yml)
[![Latest Release](https://poser.pugx.org/dompdf/dompdf/v/stable.png)](https://packagist.org/packages/dompdf/dompdf)
[![Total Downloads](https://poser.pugx.org/dompdf/dompdf/downloads.png)](https://packagist.org/packages/dompdf/dompdf)
[![License](https://poser.pugx.org/dompdf/dompdf/license.png)](https://packagist.org/packages/dompdf/dompdf)
 
**Dompdf is an HTML to PDF converter**

At its heart, dompdf is (mostly) a [CSS 2.1](http://www.w3.org/TR/CSS2/) compliant
HTML layout and rendering engine written in PHP. It is a style-driven renderer:
it will download and read external stylesheets, inline style tags, and the style
attributes of individual HTML elements. It also supports most presentational
HTML attributes.

*This document applies to the latest stable code which may not reflect the current 
release. For released code please
[navigate to the appropriate tag](https://github.com/dompdf/dompdf/tags).*

----

**Check out the [demo](http://eclecticgeek.com/dompdf/debug.php) and ask any
question on [StackOverflow](https://stackoverflow.com/questions/tagged/dompdf) or
in [Discussions](https://github.com/dompdf/dompdf/discussions).**

Follow us on [![Twitter](http://twitter-badges.s3.amazonaws.com/twitter-a.png)](http://www.twitter.com/dompdf).

---



## Features

 * Handles most CSS 2.1 and a few CSS3 properties, including @import, @media &
   @page rules
 * Supports most presentational HTML 4.0 attributes
 * Supports external stylesheets, either local or through http/ftp (via
   fopen-wrappers)
 * Supports complex tables, including row & column spans, separate & collapsed
   border models, individual cell styling
 * Image support (gif, png (8, 24 and 32 bit with alpha channel), bmp & jpeg)
 * No dependencies on external PDF libraries, thanks to the R&OS PDF class
 * Inline PHP support
 * Basic SVG support (see "Limitations" below)
 
## Requirements

 * PHP version 7.1 or higher
 * DOM extension
 * MBString extension
 * php-font-lib
 * php-svg-lib
 
Note that some required dependencies may have further dependencies 
(notably php-svg-lib requires sabberworm/php-css-parser).

### Recommendations

 * OPcache (OPcache, XCache, APC, etc.): improves performance
 * GD (for image processing)
 * IMagick or GMagick extension: improves image processing performance

Visit the wiki for more information:
https://github.com/dompdf/dompdf/wiki/Requirements

## About Fonts & Character Encoding

PDF documents internally support the following fonts: Helvetica, Times-Roman,
Courier, Zapf-Dingbats, & Symbol. These fonts only support Windows ANSI
encoding. In order for a PDF to display characters that are not available in
Windows ANSI, you must supply an external font. Dompdf will embed any referenced
font in the PDF so long as it has been pre-loaded or is accessible to dompdf and
reference in CSS @font-face rules. See the
[font overview](https://github.com/dompdf/dompdf/wiki/About-Fonts-and-Character-Encoding)
for more information on how to use fonts.

The [DejaVu TrueType fonts](https://dejavu-fonts.github.io/) have been pre-installed
to give dompdf decent Unicode character coverage by default. To use the DejaVu
fonts reference the font in your stylesheet, e.g. `body { font-family: DejaVu
Sans; }` (for DejaVu Sans). The following DejaVu 2.34 fonts are available:
DejaVu Sans, DejaVu Serif, and DejaVu Sans Mono.

## Easy Installation

### Install with composer

To install with [Composer](https://getcomposer.org/), simply require the
latest version of this package.

```bash
composer require dompdf/dompdf
```

Make sure that the autoload file from Composer is loaded.

```php
// somewhere early in your project's loading, require the Composer autoloader
// see: http://getcomposer.org/doc/00-intro.md
require 'vendor/autoload.php';

```

### Download and install

Download a packaged archive of dompdf and extract it into the 
directory where dompdf will reside

 * You can download stable copies of dompdf from
   https://github.com/dompdf/dompdf/releases
 * Or download a nightly (the latest, unreleased code) from
   http://eclecticgeek.com/dompdf

Use the packaged release autoloader to load dompdf, libraries,
and helper functions in your PHP:

```php
// include autoloader
require_once 'dompdf/autoload.inc.php';
```

Note: packaged releases are named according using semantic
versioning (_dompdf_MAJOR-MINOR-PATCH.zip_). So the 1.0.0 
release would be dompdf_1-0-0.zip. This is the only download
that includes the autoloader for Dompdf and all its dependencies.

### Install with git

From the command line, switch to the directory where dompdf will
reside and run the following commands:

```sh
git clone https://github.com/dompdf/dompdf.git
cd dompdf/lib

git clone https://github.com/PhenX/php-font-lib.git php-font-lib
cd php-font-lib
git checkout 0.5.1
cd ..

git clone https://github.com/PhenX/php-svg-lib.git php-svg-lib
cd php-svg-lib
git checkout v0.3.2
cd ..

git clone https://github.com/sabberworm/PHP-CSS-Parser.git php-css-parser
cd php-css-parser
git checkout 8.1.0
```

Require dompdf and it's dependencies in your PHP.
For details see the [autoloader in the utils project](https://github.com/dompdf/utils/blob/master/autoload.inc.php).

## Quick Start

Just pass your HTML in to dompdf and stream the output:

```php
// reference the Dompdf namespace
use Dompdf\Dompdf;

// instantiate and use the dompdf class
$dompdf = new Dompdf();
$dompdf->loadHtml('hello world');

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('A4', 'landscape');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream();
```

### Setting Options

Set options during dompdf instantiation:

```php
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('defaultFont', 'Courier');
$dompdf = new Dompdf($options);
```

or at run time

```php
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$options = $dompdf->getOptions();
$options->setDefaultFont('Courier');
$dompdf->setOptions($options);
```

See [Dompdf\Options](src/Options.php) for a list of available options.

### Resource Reference Requirements

In order to protect potentially sensitive information Dompdf imposes 
restrictions on files referenced from the local file system or the web. 

Files accessed through web-based protocols have the following requirements:
 * The Dompdf option "isRemoteEnabled" must be set to "true"
 * PHP must either have the curl extension enabled or the 
   allow_url_fopen setting set to true
   
Files accessed through the local file system have the following requirement:
 * The file must fall within the path(s) specified for the Dompdf "chroot" option

## Limitations (Known Issues)

 * Table cells are not pageable, meaning a table row must fit on a single page.
 * Elements are rendered on the active page when they are parsed.
 * Embedding "raw" SVG's (`<svg><path...></svg>`) isn't working yet, you need to
   either link to an external SVG file, or use a DataURI like this:
     ```php
     $html = '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" ...>';
     ```
     Watch https://github.com/dompdf/dompdf/issues/320 for progress
 * Does not support CSS flexbox.
 * Does not support CSS Grid.
---

[![Donate button](https://www.paypal.com/en_US/i/btn/btn_donate_SM.gif)](http://goo.gl/DSvWf)

*If you find this project useful, please consider making a donation.
Any funds donated will be used to help further development on this project.)*
