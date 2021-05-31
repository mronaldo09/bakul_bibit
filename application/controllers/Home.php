<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

    public function index($page = null)
    {
        $data['title'] = 'Homepage';
        $data["content"]    = $this->home->select(
            ["product.id","product.jumlah_stok", "product.title AS product_title", "product.description", "product.image", "product.price", "product.is_avaiable", "category.title AS category_title", "category.slug AS category_slug"]
        )
        ->join("category")
        ->where("product.is_avaiable", 1)
        ->paginate($page)
        ->get();
        $data["total_rows"] = $this->home->where("product.is_avaiable", 1)->count();
        $data["pagination"] = $this->home->makePagination(base_url("home"), 2, $data["total_rows"]);
        $data['page'] = 'pages/home/index';
        
        
        $this->view($data);
    }

}

/* End of file Home.php */
