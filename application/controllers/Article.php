<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Article extends MY_Controller
{


    public function __construct()
    {
        parent::__construct();
        $role   = $this->session->userdata("role");
        if ($role != "admin") {
            redirect(base_url("/"));
        }
    }


    public function index($page = null)
    {
        $data["title"]          = "Admin Article";
        $data["content"]        = $this->article->paginate($page)->get();
        $data["total_rows"]     = $this->article->count();
        $data["pagination"]     = $this->article->makePagination(base_url("article"), 2, $data["total_rows"]);
        $data["page"]           = "pages/article/index";

        $this->view($data);
    }

    public function search($page = null)
    {
        if (isset($_POST["keyword"])) {
            $this->session->set_userdata("keyword", $this->input->post("keyword"));
        } else {
            redirect(base_url("article"));
        }

        $keyword    = $this->session->userdata("keyword");

        $data["title"]          = "Admin Article";
        $data["content"]        = $this->article->like("title", $keyword)->get();
        $data["total_rows"]     = $this->article->like("title", $keyword)->count();
        $data["pagination"]     = $this->article->makePagination(base_url("article/search"), 3, $data["total_rows"]);
        $data["page"]           = "pages/article/index";

        $this->view($data);
    }

    public function reset()
    {

        $this->session->unset_userdata("keyword");
        redirect(base_url("article"));
    }

    public function create()
    {
        if (!$_POST) {
            $input  = (object) $this->article->getDefaultValues();
        } else {
            $input  = (object) $this->input->post(null, true);
        }

        if (!$this->article->validate()) {
            $data["title"]          = "Tambah Artikel";
            $data["input"]          = $input;
            $data["form_action"]    = "article/create";
            $data["page"]           = "pages/article/form";

            $this->view($data);
            return;
        }


        if ($this->article->create($input)) {
            $this->session->set_flashdata("success", "Data behasil disimpan!");
        } else {
            $this->session->set_flashdata("error", "Data gagal disimpan!");
        }

        redirect(base_url("article"));
    }

    public function edit($id)
    {

        $data["content"]    = $this->article->where("id", $id)->first();

        if (!$data["content"]) {
            $this->session->set_flashdata("warning", "Maaf! Data tidak ditemukan!");
            redirect(base_url("article"));
        }

        if (!$_POST) {
            $data["input"]      = $data["content"];
        } else {
            $data["input"]      = (object) $this->input->post(null, true);
        }

        if (!$this->article->validate()) {
            $data["title"]          = "Ubah Artikel";
            $data["form_action"]    = base_url("article/edit/$id");
            $data["page"]           = "pages/article/form";

            $this->view($data);
            return;
        }

        if ($this->article->where("id", $id)->update($data["input"])) {
            $this->session->set_flashdata("success", 'Data berhasil diperbarui');
        } else {
            $this->session->set_flashdata("error", 'Oops! Terjadi kesalahan');
        }

        redirect(base_url("article"));
    }


    public function delete($id)
    {

        if (!$_POST) {
            redirect(base_url("article"));
        }

        if (!$this->article->where("id", $id)->first()) {
            $this->session->set_flashdata("warning", "Maaf! Data tidak ditemukan!");
            redirect(base_url("article"));
        }

        if ($this->article->where("id", $id)->delete()) {
            $this->session->set_flashdata("success", "Data berhasil dihapus!");
        } else {
            $this->session->set_flashdata("error", 'Oops! Terjadi kesalahan');
        }

        redirect(base_url("article"));
    }



    public function unique_slug()
    {

        $slug       = $this->input->post("slug");
        $id         = $this->input->post("id");

        $article   = $this->article->where("slug", $slug)->first();

        if ($article) {
            if ($id == $article->id) {
                return true;
            }

            $this->load->library("form_validation");

            $this->form_validation->set_message("unique_slug", "%s sudah digunakan!");
            return false;
        }

        return true;
    }
}
    
    /* End of file Article.php */
