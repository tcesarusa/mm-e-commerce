<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * InvoicePlane
 *
 * @author		InvoicePlane Developers & Contributors
 * @copyright	Copyright (c) 2012 - 2017 InvoicePlane.com
 * @license		https://invoiceplane.com/license.txt
 * @link		https://invoiceplane.com
 */

/**
 * Class Mdl_Products
 */
class Mdl_Products extends Response_Model {

    public $table = 'ip_products';
    public $primary_key = 'ip_products.product_id';

    public function default_select() {
        $this->db->select('SQL_CALC_FOUND_ROWS *', false);
    }

    public function default_order_by() {
        $this->db->order_by('ip_families.family_name, ip_products.product_id', "DESC");
    }

    public function default_join() {
        $this->db->join('ip_families', 'ip_families.family_id = ip_products.family_id', 'left');
        $this->db->join('ip_units', 'ip_units.unit_id = ip_products.unit_id', 'left');
        $this->db->join('ip_tax_rates', 'ip_tax_rates.tax_rate_id = ip_products.tax_rate_id', 'left');
    }

    public function by_product($match) {
        $this->db->group_start();
        $this->db->like('ip_products.product_sku', $match);
        $this->db->or_like('ip_products.product_name', $match);
        $this->db->or_like('ip_products.product_description', $match);
        $this->db->group_end();
    }

    public function by_family($match) {
        $this->db->where('ip_products.family_id', $match);
    }

    /**
     * @return array
     */
    public function validation_rules() {
        return array(
            'product_sku' => array(
                'field' => 'product_sku',
                'label' => trans('product_sku'),
                'rules' => ''
            ),
            'product_video_url' => array(
                'field' => 'product_video_url',
                'label' => "Video URL",
                'rules' => ''
            ),
            'product_sizerequired' => array(
                'field' => 'product_sizerequired',
                'label' => "Product Size Required",
                'rules' => ''
            ),
            'product_quantity' => array(
                'field' => 'product_quantity',
                'label' => trans('product_quantity'),
                'rules' => ''
            ),
            'pcategory_id' => array(
                'field' => 'pcategory_id',
                'label' => trans('pcategory_id'),
                'rules' => ''
            ),
            'product_picture' => array(
                'field' => 'product_image',
                'label' => trans('product_picture'),
                'rules' => ''
            ),
            'product_name' => array(
                'field' => 'product_name',
                'label' => trans('product_name'),
                'rules' => 'required'
            ),
            'product_description' => array(
                'field' => 'product_description',
                'label' => trans('product_description'),
                'rules' => ''
            ),
            'product_price' => array(
                'field' => 'product_price',
                'label' => trans('product_price'),
                'rules' => 'required'
            ),
            'purchase_price' => array(
                'field' => 'purchase_price',
                'label' => trans('purchase_price'),
                'rules' => ''
            ),
            'provider_name' => array(
                'field' => 'provider_name',
                'label' => trans('provider_name'),
                'rules' => ''
            ),
            'family_id' => array(
                'field' => 'family_id',
                'label' => trans('family'),
                'rules' => 'numeric'
            ),
            'unit_id' => array(
                'field' => 'unit_id',
                'label' => trans('unit'),
                'rules' => 'numeric'
            ),
            'tax_rate_id' => array(
                'field' => 'tax_rate_id',
                'label' => trans('tax_rate'),
                'rules' => 'numeric'
            ),
            'product_color' => array(
                'field' => 'product_color',
                'label' => 'Product Color',
                'rules' => ''
            ),
            'product_size' => array(
                'field' => 'product_size',
                'label' => 'Product Size',
                'rules' => ''
            ),
            'product_model' => array(
                'field' => 'product_model',
                'label' => 'Product Model',
                'rules' => ''
            ),
            // Sumex
            'product_tariff' => array(
                'field' => 'product_tariff',
                'label' => trans('product_tariff'),
                'rules' => ''
            ),
            'ebay_price' => array(
                'field' => 'ebay_price',
                'label' => "Ebay Price",
                'rules' => 'required'
            ),
            'ebay_category_id' => array(
                'field' => 'ebay_category_id',
                'label' => "Ebay Category ID",
                'rules' => 'required'
            ),
            'ebay_category' => array(
                'field' => 'ebay_category',
                'label' => "Ebay Category",
                'rules' => 'required'
            ),
            'product_condition' => array(
                'field' => 'product_condition',
                'label' => "Product Category",
                'rules' => 'required'
            ),
            'product_mpn' => array(
                'field' => 'product_mpn',
                'label' => "Product MPN",
                'rules' => 'required'
            ),
            'product_free_shipping' => array(
                'field' => 'product_free_shipping',
                'label' => "Product Free Shipping",
                'rules' => ''
            ),
            'ebay_description' => array(
                'field' => 'ebay_description',
                'label' => "Ebay Description",
                'rules' => 'required'
            ),
            'ebay_title' => array(
                'field' => 'ebay_title',
                'label' => "Ebay Title",
                'rules' => 'required'
            )
        );
    }

    /**
     * @return array
     */
    public function db_array() {
        $db_array = parent::db_array();

        $db_array['product_price'] = (empty($db_array['product_price']) ? null : standardize_amount($db_array['product_price']));
        $db_array['purchase_price'] = (empty($db_array['purchase_price']) ? null : standardize_amount($db_array['purchase_price']));
        $db_array['family_id'] = (empty($db_array['family_id']) ? null : $db_array['family_id']);
        $db_array['unit_id'] = (empty($db_array['unit_id']) ? null : $db_array['unit_id']);
        $db_array['tax_rate_id'] = (empty($db_array['tax_rate_id']) ? null : $db_array['tax_rate_id']);

        return $db_array;
    }

}
