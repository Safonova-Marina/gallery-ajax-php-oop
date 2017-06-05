<?php

class Model_Pagination {
	public static $pagesCount;
	public static $imagesCount;
	public static $chunkPagesArray;
	public static $chunk;
	public static $viewPager;

	public function getPagesCount($size)
	{
		$imagesCount = Model_Collection::getCountImages();//считаем кол-во из-й
		$pagesCount = ceil($imagesCount / $size);//считаем кол-во страниц
		self::$pagesCount = $pagesCount;
		self::$imagesCount = $imagesCount;		
	}

	public static function getChunkPagesArray($size)
	{
		self::getPagesCount($size);
		$pagesCount = self::$pagesCount;
		//формируем массив , где номер страницы - ключ, а занчение - стартовая позиция для вывода картинки (нужно для запроса в бд)
		for( $i = 0; $i < $pagesCount; $i++)
		{
			$pagesArr[$i+1] = $i * $size;
		}
		//если размер страницы больше кол-ва из-й - будет 1 чанк
		if ($size >= self::$imagesCount) $chunkArr[] = $pagesArr;
		//если размер страницы меньше кол-ва из-й - дробим на чанки по 3 страницы в чанке
		else $chunkArr = array_chunk($pagesArr, 3, true);
		self::$chunkPagesArray = $chunkArr;	
	}

	public function getNeedChunk($size, $pageNum)
	{
		//поиск нужного чанка по номеру страницы
		self::getChunkPagesArray($size);
		$chunkPagesArray = self::$chunkPagesArray;
		//если номер страницы больше кол-ва страниц - делаем номер страницы равным 1
		if (self::$pagesCount < $pageNum) $pageNum = 1;
		foreach( $chunkPagesArray as $chunk => $pages  )
		{
			//по ключу ищем нужный чанк
			if(array_key_exists($pageNum, $pages))
			{
				self::$chunk = $chunkPagesArray[$chunk];
			}
		}	
	}

	public function getViewPager($size, $pageNum)
	{
		self::getNeedChunk($size, $pageNum);
		$chunkPagesResObj = self::$chunk;

		//формируем хтмл верстку пагинации
		if (self::$pagesCount < $pageNum) $pageNum=1;
		//если страница первая - нет стрелки назад, если последняя - убираем стрелку вперед
		$disFirst = $pageNum==1? ' style="display: none;"' : '';
		$disLast = $pageNum==self::$pagesCount? ' style="display: none;"' : '';

		$viewPagerStr = '<li'.$disFirst.'><a id="prev">&laquo;</a></li>';
		foreach( self::$chunk as $key => $value  )
		{
			//запрашиваемая страница - будет иметь активный класс
			$viewPagerStr .= '<li'.($pageNum==$key? ' class="active"' : '').'><a id="'.$key.'">'.$key.'</a></li>';
			if ($key == $pageNum) self::$viewPager->limit = $value;
		}
		$viewPagerStr .= '<li'.$disLast.'><a id="next">&raquo;</a></li>';

		self::$viewPager->str = $viewPagerStr;//отдаем верстку страницы
		self::$viewPager->pageNum = $pageNum;//отдаем номер страницы
		return self::$viewPager;
	}

}
