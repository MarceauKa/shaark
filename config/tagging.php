<?php

return [
	'primary_keys_type' => 'integer',
	'normalizer' => '\Conner\Tagging\TaggingUtility::slug',
	'displayer' => '\Illuminate\Support\Str::title',
	'untag_on_delete' => true,
	'delete_unused_tags' => false,
	'tag_model'=>'\Conner\Tagging\Model\Tag',
	'delimiter' => '-',
	'tagged_model' => '\Conner\Tagging\Model\Tagged',
];
