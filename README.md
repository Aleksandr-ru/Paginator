# Paginator
Paginator with formatting features

## Usage
Bootstrap pagination
````
require 'Paginator.php';
$paginator = new Paginator(0, 100);
$paginator->showOutput('?page={PAGE}&value={VALUE}', 'bootstrap');
````

JSON pagination
````
require 'Paginator.php';
$paginator = new Paginator(10, 100, 5);
$json = $paginator->getOutput('?page={PAGE}&value={VALUE}', 'json');
````

### Custom format - array of markup
````
$format = array(
'before'        => "<ul class='pagination'>\n",
'prev'          => "\t<li><a href='{HREF}' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>\n",
'prev-disabled' => "\t<li class='disabled'><span><span aria-hidden='true'>&laquo;</span></span></li>\n",
'page'          => "\t<li><a href='{HREF}'>{PAGE}</a></li>\n",
'page-active'   => "\t<li class='active'><span>{PAGE} <span class='sr-only'>(current)</span></span></li>\n",
'space'         => "\t<li class='disabled'><span><span aria-hidden='true'>&hellip;</span></span></li>\n",
'next'          => "\t<li><a href='{HREF}' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>\n",
'next-disabled' => "\t<li class='disabled'><span><span aria-hidden='true'>&raquo;</span></span></li>\n",
'after'         => "</ul>\n"
);
require 'Paginator.php';
$paginator = new Paginator(0, 100);
$paginator->addFormat('myformat', $format);
$paginator->showOutput('?page={PAGE}&value={VALUE}', 'myformat');
````
Now you cat use 'myformat' in getOutput() and showOutput() to get HTML markup.

### Custom format - callback function
````
require 'Paginator.php';
$paginator = new Paginator(0, 100);
$paginator->addFormat('serialized', 'serialize');
$serialized = $paginator->getOutput('?page={PAGE}&value={VALUE}', 'serialized');
````
Now you cat use 'serialized' in getOutput() and showOutput() to get serialized data.
