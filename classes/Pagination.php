<?php

class Pagination {

	public static function getPagesCount($size)
	{
		$countImages = Collection::getCountImages();
		$pagesCount = ceil($countImages / $size);
		$total->pagesCount = $pagesCount;
		$total->images = $countImages;
		return $total;		
	}

	public static function getChunkPagesArray($size)
	{
		$pagesCount = self::getPagesCount($size);
		$chunkPagesArray->pagesCount = $pagesCount->pagesCount;
		for( $i = 0; $i < $pagesCount->pagesCount; $i++)
		{
			$pagesArr[$i+1] = $i * $size;
		}

		if ($size >= $pagesCount->images) $chunkArr[] = $pagesArr;
		else $chunkArr = array_chunk($pagesArr, 3, true);
		$chunkPagesArray->chunkArr = $chunkArr;
		return $chunkPagesArray;		
	}

	public static function getNeedChunk($size, $pageNum)
	{
		$chunkPagesResObj;
		$chunkPagesArray = self::getChunkPagesArray($size);
		// print_r($chunkPagesArray);
		$chunkPagesResObj->len = $chunkPagesArray->pagesCount;
		$chunkArr = $chunkPagesArray->chunkArr;
		if ($chunkPagesArray->pagesCount < $pageNum) $pageNum = 1;
		foreach( $chunkArr as $chunk => $pages  )
		{
			if(array_key_exists($pageNum, $pages))
			{
				$chunkPagesResObj->chunk = $chunkArr[$chunk];
				return $chunkPagesResObj;
			}
		}	
	}

	public static function getViewPager($size, $pageNum)
	{
		$chunkPagesResObj = self::getNeedChunk($size, $pageNum);
		// print_r($chunkPagesResObj);

		if ($chunkPagesResObj->len < $pageNum) $pageNum=1;
		$disFirst = $pageNum==1? ' style="display: none;"' : '';
		$disLast = $pageNum==$chunkPagesResObj->len? ' style="display: none;"' : '';

		$viewPagerStr = '<li'.$disFirst.'><a id="prev">&laquo;</a></li>';
		foreach( $chunkPagesResObj->chunk as $key => $value  )
		{
			$viewPagerStr .= '<li'.($pageNum==$key? ' class="active"' : '').'><a id="'.$key.'">'.$key.'</a></li>';
			if ($key == $pageNum) $viewPager->limit = $value;
		}
		$viewPagerStr .= '<li'.$disLast.'><a id="next">&raquo;</a></li>';

		$viewPager->str = $viewPagerStr;
		$viewPager->pageNum = $pageNum;
		return $viewPager;
	}

}
?>