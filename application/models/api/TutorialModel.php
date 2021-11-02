<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TutorialModel extends Render_Model
{
  public function tutorial_list()
  {
    $data = $this->db->select("id, nama, keterangan, foto, url")
      ->from('tutorial')
      ->order_by('created_at', 'desc');

    $data = $data->get()->result_array();
    $return = [
      'data' => $data,
      'length' => $data == null ? 0 : 1
    ];
    return $return;
  }

  public function tutorial_get($id = null)
  {
    $data = $this->db->select("id, nama, keterangan, foto, url")
      ->from('tutorial')
      ->where('id', $id)
      ->order_by('created_at', 'desc');

    $data = $data->get()->row_array();
    $return = [
      'data' => $data,
      'length' => $data == null ? 0 : 1
    ];
    return $return;
  }
}
