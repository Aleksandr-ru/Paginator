<?php
/**
* @abstract на удивление простая штука, но требующая серьезной реализации
*/
class Paginator
{
	const DEFAULT_LIMIT = 20;
	const DEFAULT_MIN = 0;
	const DEFAULT_RANGE = 3;
	
	protected $formats = array(
		'json' => FALSE,
		'bootstrap' => array(
			'before'        => "<ul class='pagination'>\n",
			'prev'          => "\t<li><a href='#' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>\n",
			'prev-disabled' => "\t<li class='disabled'><span><span aria-hidden='true'>&laquo;</span></span></li>\n",
			'page'          => "\t<li><a href='#'>1</a></li>\n",
			'page-active'   => "\t<li class='active'><span>1 <span class='sr-only'>(current)</span></span></li>\n",
			'space'         => "\t<li class='disabled'><span><span aria-hidden='true'>&hellip;</span></span></li>\n",
			'next'          => "\t<li><a href='#' aria-label='Next'><span aria-hidden='true'>&raquo;</span></a></li>\n",
			'next-disabled' => "\t<li class='disabled'><span><span aria-hidden='true'>&raquo;</span></span></li>\n",
			'after'         => "</ul>\n"
		)
	);
	
	protected $pages;
	
	/**
	* 
	* @param int $value текущее значение
	* @param int $total максимальное значение
	* @param int $limit элементов на странице
	* @param int $min минимальное значение
	* @param int $range кол-во отображемых страниц от текущей
	* 
	* @return
	*/
	function __construct($value, $total, $limit = self::DEFAULT_LIMIT, $min = self::DEFAULT_MIN, $range = self::DEFAULT_RANGE)
	{
		$total_pages = ceil(($total - $min) / $limit);
		$current_page = floor(($value - $min) / $limit) + 1; //TODO: проверить так-ли это
		
		if($total_pages < ($range+1)* 2) { // тут все просто, рисуем с первой по последнюю
			$min_page = 1;
			$max_page = $total_pages;
			$space_before = FALSE;
			$space_after = FALSE;
		}
		else { // а вот это сложный вариант
			$min_page = $current_page - $range;
			if($min_page <= 2) $min_page = 1; // чтоб не было дырок в одну страницу
			$space_before = ($min_page != 1);
			
			$max_page = $current_page + $range;
			if($total_pages - $max_page <= 2) $max_page = $total_pages; // тоже чтоб не было дырок
			$space_after = ($max_page != $total_pages);
		}
		
		// предыдущая страница
		if($current_page > 1) $this->pages[] = array(
			'type' => 'prev',
			'page' => $current_page - 1,
			'value' => 0				
		);
		else $this->pages[] = array(
			'type' => 'prev-disabled'
		);
		// пробел
		if($space_before) $this->pages[] = array(
			'type' => 'space'
		);
		// сраницы
		for($p = $min_page; $p <= $max_page; $p++) {
			if($p == $current_page) $this->pages[] = array(
				'type' => 'page-active',
				'page' => $current_page,
				'value' => 0				
			);	
			else $this->pages[] = array(
				'type' => 'page',
				'page' => $p,
				'value' => 0				
			);	
		}
		// пробел
		if($space_after) $this->pages[] = array(
			'type' => 'space'
		);
		// следующая страница
		if($current_page < $total_pages) $this->pages[] = array(
			'type' => 'next',
			'page' => $current_page + 1,
			'value' => 0				
		);
		else $this->pages[] = array(
			'type' => 'next-disabled'
		);
	}
	
	function addFormat($name, $format)
	{
		$this->formats[$name] = $format;
	}
	
	function getOutput($href)
	{
		
	}
	
	function showOutput($href = "?page=%p&value=%v")
	{
		return $this->getOutput($href);
	}
}
?>