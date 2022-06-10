  $member_datas = array();
  while ($member_d = $member_q->fetch_assoc()) {
    if ($member_d['member_id']) {
      $member_datas[] = $member_d;
    }
  }