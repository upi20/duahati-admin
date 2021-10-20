<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TebakSkorModel extends Render_Model
{
  public function getData($id_member, $id_pertandingan)
  {
    $return = [
      'data' => '',
      'length' => 0
    ];
    $current = $this->db->select('score_team_1 as team_1, score_team_2 as team_2, status')
      ->from('tebak_score')
      ->where('id_member', $id_member)
      ->where('id_pertandingan', $id_pertandingan)
      ->get();
    if ($current->num_rows() > 0) {
      $return = [
        'data' => $current->row_array(),
        'length' => $current->num_rows()
      ];
    } else {
      $this->db->insert('tebak_score', [
        'id_member' => $id_member,
        'id_pertandingan' => $id_pertandingan,
        'score_team_1' => 0,
        'score_team_2' => 0,
        'status' => 0,
      ]);
      $return = [
        'data' => [
          'team_1' => 0,
          'team_2' => 0,
          'status' => 0,
        ],
        'length' => 1
      ];
    }

    return $return;
  }

  public function simpan($id_member, $id_pertandingan, $team_1, $team_2)
  {
    $this->db->where('id_member', $id_member)
      ->where('id_pertandingan', $id_pertandingan);

    return $this->db->update('tebak_score', [
      'score_team_1' => $team_1,
      'score_team_2' => $team_2,
      'status' => 1,
      'updated_at' => Date('Y-m-d h:i:s')
    ]);
  }
}
