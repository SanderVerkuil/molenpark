<?php

class Voting extends \Eloquent {
	protected $fillable = ['ended', 'created_by'];
	protected $table = "votings";
}