<?php

class AjaxController extends BaseController {

	function songs()
	{
		return json_encode(Song::all());
	}

}