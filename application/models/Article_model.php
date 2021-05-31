<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Article_model extends MY_Model
{

    protected $perPage = 5;

    public function getDefaultValues()
    {

        return  [
            "id"        => "",
            "slug"      => "",
            "title"     => "",
            "description"     => "",
        ];
    }

    public function getValidationRules()
    {

        $validationRules    = [
            [
                "field"   => "slug",
                "label"    => "Slug",
                "rules"    => "trim|required|callback_unique_slug"
            ],

            [
                "field"   => "title",
                "label"    => "Kategori",
                "rules"    => "trim|required"
            ],

            [
                "field"   => "description",
                "label"    => "Deskripsi",
                "rules"    => "trim|required"
            ],
        ];

        return $validationRules;
    }
}

/* End of file Article_model.php */
