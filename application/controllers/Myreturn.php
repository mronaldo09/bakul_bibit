<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Myreturn extends MY_Controller
{

    private $id;

    public function __construct()
    {
        parent::__construct();
        $is_login = $this->session->userdata("is_login");
        $this->id  = $this->session->userdata("id");

        if (!$is_login) {
            redirect(base_url());
            return;
        }
    }

    public function index()
    {
        $data["title"]      = "Daftar Order";
        $data["content"]    =
            $this->myreturn->where("id_user", $this->id)->where("status", "delivered")->orderBy("date", "DESC")->get();
        $data["page"]       = "pages/myreturn/index";

        $this->view($data);
    }

    public function detail($invoice)
    {
        $data["order"]  = $this->myreturn->where("invoice", $invoice)->first();
        if (!$data["order"]) {
            $this->session->set_flashdata("warning", "Data tidak ditemukan!");
            redirect(base_url("/myreturn"));
        }

        $this->myreturn->table   = "orders_detail";
        $data["order_detail"]   = $this->myreturn->select([
            "orders_detail.id_orders", "orders_detail.id_product", "orders_detail.qty", "orders_detail.subtotal", "product.title", "product.image", "product.price"
        ])
            ->join("product")
            ->where("orders_detail.id_orders", $data["order"]->id)
            ->get();

        if ($data["order"]->status !== "delivered") {
            $this->myreturn->table   = "pengembalian";
            $data["pengembalian"] = $this->myreturn->where("id_orders", $data["order"]->id)->first();
        }

        $data["page"]   = "pages/myreturn/detail";

        $this->view($data);
    }

    public function confirm($invoice)
    {

        $data["order"]  = $this->myreturn->where("invoice", $invoice)->first();
        if (!$data["order"]) {
            $this->session->set_flashdata("warning", "Data tidak ditemukan!");
            redirect(base_url("/myreturn"));
        }


        if (!$_POST) {
            $data["input"]  = (object) $this->myreturn->getDefaultValues();
        } else {
            $data["input"]  = (object) $this->input->post(null, true);
        }

        if (!empty($_FILES) && $_FILES["image"]["name"] !== "") {
            $imageName  = url_title($invoice, '-', true) . "-" . date("YmdHis");
            $upload     = $this->myreturn->uploadImage("image", $imageName);
            if ($upload) {
                $data["input"]->image   = $upload["file_name"];
            } else {
                redirect(base_url("myreturn/confirm/$invoice"));
            }
        }

        if (!$this->myreturn->validate()) {
            $data["title"]  = "Pengembalian";
            $data["form_action"]    = base_url("myreturn/confirm/$invoice");
            $data["page"]           = "pages/myreturn/confirm";

            $this->view($data);
            return;
        }

        $this->myreturn->table = "pengembalian";

        if ($this->myreturn->create($data["input"])) {
            $this->session->set_flashdata("success", "Pengembalian akan segera kami proses.");
        } else {
            $this->session->set_flashdata("error", "Data gagal disimpan!");
        }
        redirect(base_url("myorder/detail/$invoice"));
    }

    public function image_required()
    {
        if (empty($_FILES) || $_FILES["images"]["name"] === "") {
            $this->session->set_flashdata("image_error", "Bukti tidak boleh kosong, ");
            return false;
        }
        return true;
    }
}

/* End of file Myreturn.php */
