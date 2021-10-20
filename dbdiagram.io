// member
Table member{
  id int [pk, increment]
  nik varcharacter
  nama varcharacter
  no_telepon varcharacter
  tanggal_lahir date
  jenis_kelasmin varchar
  password varchar
  email varchar
  status int
  created_by int
  updated_by int
  created_at datetime
  updated_at datetime
}
ref: member.created_by - users.user_id
ref: member.updated_by - users.user_id

// users
Table users{
  user_id int [pk, increment]
  nik varcharacter
  nama varcharacter
  tgl_lahir date
  jenis_kelasmin varchar
  user_password varchar
  user_email varchar
  user_status int
  created_at datetime
  updated_at datetime
}

// kelas
Table kelas_kategori{
  id int [pk, increment]
  nama  varchar
  status int
  created_by int
  updated_by int
  created_at datetime
  updated_at datetime
}
ref: kelas_kategori.created_by - users.user_id
ref: kelas_kategori.updated_by - users.user_id


Table kelas{
  id int [pk, increment]
  id_kategori int
  nama varchar
  created_by int
  updated_by int
  created_at datetime
  updated_at datetime
}
ref: kelas.id_kategori - kelas_kategori.id
ref: kelas.created_by - users.user_id
ref: kelas.updated_by - users.user_id

Table kelas_materi{
  id int [pk, increment]
  url varchar
  keterangan text
  created_by int
  updated_by int
  created_at datetime
  updated_at datetime
}
ref: kelas_materi.created_by - users.user_id
ref: kelas_materi.updated_by - users.user_id

Table kelas_member_tonton{
  id int [pk, increment]
  member_id int
  created_by int
  updated_by int [default: null]
  created_at datetime
  updated_at datetime
}
ref: kelas_member_tonton.created_by - users.user_id
ref: kelas_member_tonton.updated_by - users.user_id
ref: kelas_member_tonton.member_id - member.id