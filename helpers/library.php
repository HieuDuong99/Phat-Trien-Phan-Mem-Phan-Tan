<?php 
class Library {
	public static function uploadFiles($file, $path) {
		if ($file['error'] == 0) {
			if ($file['size'] < 1024 * 1024 *2) {
				if (!empty($file['name'])) {
					$name = $file['name'];
					$tmp = $file['tmp_name'];

					$basename = explode(".", $name);
					$extension = end($basename);

					$extension = strtolower($extension);
					if (in_array($extension, ['jpg', 'png', 'jpeg'])) {
						$new_file = time().'-'.$name;
						$upload_path = $path.'/'.$new_file;
						$check = move_uploaded_file($tmp, $upload_path);
						if ($check) {
							return $new_file;
						}
						return false;
					}
				}
			} else {
				return 1;
			}
		} else {
			return $file['error'];
		}

		return false;
	}

	public static function deleteFiles($file, $path) {
		unlink($path.'/'.$file);
	}
	
	public static function paging($link, $data, $page, $limit, $keyword = "") {
		$total = count($data);
		$total_page = ceil($total/$limit);
		$html = '<nav aria-label="Page navigation">
					<ul class="pagination">';
		$currentPage = $page;
		$start = $limit*($page-1);

		if ($currentPage < 1) {
			$currentPage = 1;
		} elseif ($currentPage > $total_page) {
			$currentPage = $total_page;
		}

		if ($currentPage > 1 && $total_page > 1) {
			$html .= '<li class="page-item cursor-pointer"><a class="page-link" href="'.str_replace("{page}", 1, $link).'" aria-label="First"><span aria-hidden="true"><i class="fa fa-angle-double-left"></i></span></a></li>';
		} else {
			$html .= '<li class="page-item disabled"><a class="page-link" aria-label="First"><span aria-hidden="true"><i class="fa fa-angle-double-left"></i></span></a></li>';
		}

		if ($currentPage > 1 && $total_page > 1) {
			$html .= "<li class='page-item cursor-pointer'>";
			$html .= '<a class="page-link" href="'.str_replace("{page}", $currentPage-1, $link).'" aria-label="Previous">';
			$html .= '<span aria-hidden="true"><i class="fa fa-angle-left"></i></span>';
			$html .= '</a>';
			$html .= '</li>';
		} else {
			$html .= "<li class='page-item disabled'>";
			$html .= '<a class="page-link" aria-label="Previous">';
			$html .= '<span aria-hidden="true"><i class="fa fa-angle-left"></i></span>';
			$html .= '</a>';
			$html .= '</li>';
		}

		for ($i = 1; $i <= $total_page; $i++) {
			if ($currentPage == $i) {
				$html .= '<li class="page-item active cursor-pointer"><a class="page-link" href="'.str_replace("{page}", $i, $link).'">'.$i.'</a></li>';
			} else {
				$html .= '<li class="page-item cursor-pointer"><a class="page-link" href="'.str_replace("{page}", $i, $link).'">'.$i.'</a></li>';
			}
		}
		if ($total_page > 1 && $currentPage < $total_page) {
			$html .= '<li class="page-item cursor-pointer"><a class="page-link" href="'.str_replace("{page}", $currentPage+1, $link).'" aria-label="Next"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>';
		} else {
			$html .= '<li class="page-item disabled"><a class="page-link" aria-label="Next"><span aria-hidden="true"><i class="fa fa-angle-right"></i></span></a></li>';
		}

		if ($total_page > 1 && $currentPage < $total_page) {
			$html .= '<li class="page-item cursor-pointer"><a class="page-link" href="'.str_replace("{page}", $total_page, $link).'" aria-label="Last"><span aria-hidden="true"><i class="fa fa-angle-double-right"></i></span></a></li>';
		} else {
			$html .= '<li class="page-item disabled"><a class="page-link" aria-label="Last"><span aria-hidden="true"><i class="fa fa-angle-double-right"></i></span></a></li>';
		}

		$html .= '	</ul>
				</nav>';
		
		$paging = array(
			'limit' => $limit,
			'start' => $start,
			'html' => $html,
			'keyword' => $keyword,
			'data' => array_chunk($data, $limit)
		);
		return $paging;
	}

	public static function createLink($uri, $filters = []) {
		$query = '';
		foreach ($filters as $key => $filter) {
			$query .= "{$key}={$filter}&";
		}
		$query = rtrim($query, "&");
		return $uri."?".$query;
	}
}
 ?>