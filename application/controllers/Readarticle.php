<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Readarticle extends MY_Controller
{
    public function index($page = null)
    {
        $data["title"]          = "Read Article";
        $data["content"]        = $this->readarticle->paginate($page)->get();
        $data["total_rows"]     = $this->readarticle->count();
        $data["pagination"]     = $this->readarticle->makePagination(base_url("readarticle"), 2, $data["total_rows"]);
        $data["page"]           = "pages/Readarticle/index";

        $this->view($data);
    }



    public function detail($slug)
    {
        $data["title"]          = "Detail Article";
        $data["content"]        = $this->readarticle->where("slug", $slug)->first();
        $data["page"]           = "pages/Readarticle/detail";

        $this->view($data);
    }
}
    
    /* End of file Readarticle.php */
