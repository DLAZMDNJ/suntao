<?php

namespace jamx\Repositories;

use jamx\Models\Document;
use jamx\Models\Dict;
use Illuminate\Support\Facades\Input;


class DocumentRepository extends VmisRepository
{

    

    /**
     * Create a new MetaRepository instance.
     *
     * @param  jamx\Models\Meta $meta
     * @param  jamx\Models\Content $content
     * @return void
     */
    public function __construct(
        Document $model)
    {
        $this->model = $model;
        
    }
    public function format_names(){
    	return array('category'=>'document_category','uid'=>'user');
    }
    

}
