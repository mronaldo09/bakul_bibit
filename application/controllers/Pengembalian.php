<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Pengembalian extends MY_Controller {

    public function __construct()
        {
            parent::__construct();
            $role   = $this->session->userdata("role");
            if ($role != "admin") {
                redirect(base_url("/"));
            }        }
        

    public function index($page = null)
    {
            $data["title"]          = "Admin Pengembalian";
            $data["pengembalian"]   = $this->pengembalian->select([
                "pengembalian.status", "pengembalian.note", "pengembalian.image", "orders.invoice", "orders.id"
            ])
                ->join("orders")
                ->get();
            $data["total_rows"]     = $this->pengembalian->count();
            $data["pagination"]     = $this->pengembalian->makePagination(base_url("pengembalian"), 2, $data["total_rows"]);
            $data["page"]           = "pages/pengembalian/index";

            $this->view($data);
    }

    public function detail($id)
    {
        $this->pengembalian->table   = "orders";

        $data["order"]  = $this->pengembalian->where("id", $id)->first();
        if (!$data["order"]) {
            $this->session->set_flashdata("warning", "Data tidak ditemukan!");
            redirect(base_url("pengembalian"));
        }

        $this->pengembalian->table   = "orders_detail";
        $data["order_detail"]   = $this->pengembalian->select([
            "orders_detail.id_orders", "orders_detail.id_product", "orders_detail.qty", "orders_detail.subtotal", "product.title", "product.image", "product.price"
        ])
        ->join("product")
        ->where("orders_detail.id_orders", $id)
        ->get();
        
        $this->pengembalian->table   = "pengembalian";

        $data["my_return"] = $this->pengembalian->where("id_orders", $data["order"]->id)->first();


        $data["page"]   = "pages/pengembalian/detail";

        $this->view($data);
    }

    public function update($id)
    {
        if (!$_POST) {
            $this->session->set_flashdata("error", "Oops! Terjadi kesalahan!");
            redirect(base_url("/pengembalian/detail/$id"));
        }

        if ($this->pengembalian->where("id", $id)->update(["status" => $this->input->post("status")])) {
            $this->session->set_flashdata("success", "Data berhasil diperbarui.");
        } else{
            $this->session->set_flashdata("error", "Oops! Terjadi kesalahan!");
        }
        redirect(base_url("pengembalian/detail/".$this->input->post("id_orders")));
    }

    public function search($page = null){
        if (isset($_POST["keyword"])) {
            $this->session->set_userdata("keyword", $this->input->post("keyword"));
        } else {
            redirect(base_url("order"));
        }

        $keyword    = $this->session->userdata("keyword");

        $data["title"]          = "Admin Order";
        $data["content"]        = $this->order->like("date", $keyword)->orderBy("date", "DESC")->get();
        $data["total_rows"]     = $this->order->like("date", $keyword)->orderBy("date", "DESC")->count();
        $data["pagination"]     = $this->order->makePagination(base_url("order/search"), 3, $data["total_rows"]);
        $data["page"]           = "pages/order/index";

        $this->view($data);
    }

    public function reset(){

        $this->session->unset_userdata("keyword");
        redirect(base_url("order"));


    }
    
  

}

/* End of file Pengembalian.php */
