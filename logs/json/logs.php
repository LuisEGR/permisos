<?php

/*
                <th>ID</th>
                <th>permiso_id</th>
                <th>user_id</th>
				<th>action</th>
				<th>user_modified</th>
				<th>time</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td style="width:30px"></td>
                <td>11025</td>
                <td>75</td>
                <td>95</td>
				<td>deny</td>
				<td>28</td>
				<td>2017-02-20 16:22:52</td>

*/

$registros = array();
$registros[] = array(
						'id' => 11025,
						'permiso_id' => 75,
						'user_id' => 95,
						'action' => 'deny',
						'user_modified' => 28,
						'time' => '2017-02-20 16:22:52'
					);
					
$registros[] = array(
						'id' => 11025,
						'permiso_id' => 75,
						'user_id' => 95,
						'action' => 'deny',
						'user_modified' => 28,
						'time' => '2017-02-20 16:22:52'
					);

$data = array(
				'noRegistros' => 100,
				'page' => 4,
				'adjacents' => 3,
				'registros' => $registros
			);

header('Content-Type: application/json');
			
echo json_encode($data);
	
?>