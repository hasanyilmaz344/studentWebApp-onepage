<!DOCTYPE html>
<html lang="en">
<body>
    <?php
    // function header
    pageHead();
    // database connection
    $mysqli = new mysqli("localhost", "root", "", "studentwebapp");
    // check all value for operation
    if (true) {
        // filter
        if (isset($_GET['sidlike'])) {
            $sidlike = $_GET['sidlike'];
        } else {
            $sidlike = '';
        }
        if (isset($_GET['fnamelike'])) {
            $fnamelike = $_GET['fnamelike'];
        } else {
            $fnamelike = '';
        }
        if (isset($_GET['lnamelike'])) {
            $lnamelike = $_GET['lnamelike'];
        } else {
            $lnamelike = '';
        }
        if (isset($_GET['snumberlike'])) {
            $snumberlike = $_GET['snumberlike'];
        } else {
            $snumberlike = '';
        }
        if (isset($_GET['departmentlike'])) {
            $departmentlike = $_GET['departmentlike'];
        } else {
            $departmentlike = '';
        }
        if (isset($_GET['birthdatelike'])) {
            $birthdatelike = $_GET['birthdatelike'];
        } else {
            $birthdatelike = '';
        }

        // pagination
        if (isset($_GET['pagenumb'])) {
            $pagenumb = $_GET['pagenumb'];
        } else {
            $pagenumb = 1;
        }

        // create & update
        if (isset($_POST['fname'])) {
            $fname = ($_POST['fname']);
        } else {
            $fname = '';
        }
        if (isset($_POST['lname'])) {
            $lname = ($_POST['lname']);
        } else {
            $lname = '';
        }
        if (isset($_POST['snumber'])) {
            $snumber = ($_POST['snumber']);
        } else {
            $snumber = '';
        }
        if (isset($_POST['department'])) {
            $department = ($_POST['department']);
        } else {
            $department = '';
        }
        if (isset($_POST['birthdate'])) {
            $birthdate = ($_POST['birthdate']);
        } else {
            $birthdate = '2023-01-01';
        }

        // delete & update
        if (isset($_GET['thesid'])) {
            $thesid = $_GET['thesid'];
        } elseif (isset($_POST['thesid'])) {
            $thesid = $_POST['thesid'];
        } else {
            $thesid = '';
        }

        //  operation value post&get
        if (isset($_GET['op'])) {
            $op = $_GET['op'];
        } elseif (isset($_POST['op'])) {
            $op = $_POST['op'];
        } else {
            $op = '';
        }

        // liststudent  
        if (isset($_GET['colname'])) {
            $colname = $_GET['colname'];
        } else {
            $colname = 'sid';
        }
        if (isset($_GET['asc'])) {
            $asc = $_GET['asc'];
        } else {
            $asc = 'ASC';
        }
    }
    // select option with switch 
    switch ($op) {
        case 'add':
            add();
            break;
        case 'insert':
            insert($mysqli, $fname, $lname, $snumber, $department, $birthdate, $op);
            break;
        case 'delete':
            delete($mysqli, $thesid);
            break;
        case 'update':
            update($thesid);
            break;
        case 'updateTo':
            updateTo($mysqli, $thesid, $fname, $lname, $snumber, $department, $birthdate);
            break;
        case 'listStudent':
            listStudent($pagenumb, $mysqli, $sidlike, $fnamelike, $lnamelike, $snumberlike, $departmentlike, $birthdatelike, $colname, $asc);
            break;
        default:
            listStudent(1, $mysqli, $sidlike, $fnamelike, $lnamelike, $snumberlike, $departmentlike, $birthdatelike, $colname, $asc);
            break;
    }

    // create view
    function add()
    {
    ?>
        <div>
            <form action="index.php" method="POST" style="margin-left:auto;margin-right:auto; width: 50%;">
                <input type="hidden" name="op" id="op" value="insert">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label>isim </label>
                        <input type="text" required="" class="form-control" name="fname" placeholder="adinizi giriniz" value="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>soyisim </label>
                        <input type="text" required="" class="form-control" name="lname" placeholder="soyadinizi giriniz" value="">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>ogrenci no </label>
                        <input type="text" required="" class="form-control" name="snumber" placeholder="ogrenci no giriniz" value="1">
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label>bolum </label>
                        <input type="text" required="" class="form-control" name="department" placeholder="bolumunuzu giriniz" value="">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>dogum tarihi </label>
                        <input type="date" required="" class="form-control" name="birthdate" value="2023-01-01">
                    </div>
                    <div class="col-md-12 mb-3">
                        <button class="btn btn-primary" type="submit" name="insert">Create Student</button>
                    </div>
                </div>
            </form>
        </div>
    <?php
    }

    // create post
    function insert($mysqli, $fname, $lname, $snumber, $department, $birthdate)
    {
        $fname =  mysqli_real_escape_string($mysqli, $fname);
        $lname =  mysqli_real_escape_string($mysqli, $lname);
        $snumber =  mysqli_real_escape_string($mysqli, $snumber);
        $department =  mysqli_real_escape_string($mysqli, $department);
        $birthdate=  mysqli_real_escape_string($mysqli, $birthdate);

        $sql = "INSERT INTO Student (fname, lname, snumber,department,birthdate)
            VALUES  ('$fname', '$lname', '$snumber','$department','$birthdate')";
        $mysqli->query($sql);
        listStudent(1, $mysqli);
    }

    // delete post
    function delete($mysqli, $thesid)
    {
        $deleteID = $thesid;
        $sql = "DELETE FROM Student WHERE sid=$deleteID";
        $mysqli->query($sql);
        listStudent(1, $mysqli);
    };

    // update view
    function update($thesid)
    { ?>
        <form action="index.php" method="POST" style="margin-left:auto;margin-right:auto; width: 50%;">

            <input type="hidden" name="thesid" value="<?php echo $thesid ?>">
            <input type="hidden" name="op" id="op" value="updateTo">

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label>isim </label>
                    <input type="text" required="" class="form-control" name="fname" placeholder="adinizi giriniz" value="">
                </div>
                <div class="col-md-4 mb-3">
                    <label>soyisim </label>
                    <input type="text" required="" class="form-control" name="lname" placeholder="soyadinizi giriniz" value="">
                </div>
                <div class="col-md-4 mb-3">
                    <label>ogrenci no </label>
                    <input type="text" required="" class="form-control" name="snumber" placeholder="ogrenci no giriniz" value="">
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label>bolum </label>
                    <input type="text" required="" class="form-control" name="department" placeholder="bolumunuzu giriniz" value="">
                </div>
                <div class="col-md-6 mb-3">
                    <label>dogum tarihi </label>
                    <input type="date" required="" class="form-control" name="birthdate" value="">
                </div>
                <div class="col-md-12 mb-3">
                    <button class="btn btn-warning" type="submit" name="updateTo">güncelle</button>
                </div>
            </div>
        </form>
    <?php
    }

    // update post
    function updateTo($mysqli, $sid, $fname, $lname, $snumber, $department, $birthdate)
    {
        $fname =  mysqli_real_escape_string($mysqli, $fname);
        $lname =  mysqli_real_escape_string($mysqli, $lname);
        $snumber =  mysqli_real_escape_string($mysqli, $snumber);
        $department =  mysqli_real_escape_string($mysqli, $department);
        $birthdate=  mysqli_real_escape_string($mysqli, $birthdate);

        $sql = "UPDATE student SET fname='$fname', lname='$lname', snumber='$snumber', department='$department', birthdate='$birthdate' WHERE sid=$sid";
        $mysqli->query($sql);
        listStudent(1, $mysqli);
    }

    // read
    function listStudent($pagenumb, $mysqli, $sidlike = '', $fnamelike = '', $lnamelike = '', $snumberlike = '', $departmentlike = '', $birthdatelike = '', $colname = 'sid', $asc = 'ASC')
    {

    ?>
        <div id="maindiv" style="margin-left: auto; margin-right: auto;padding-top: 40px; padding-left: 40px; padding-right: 40px;">
            <?php
            // sql reading
            $limitnumber = ($pagenumb - 1) * 5;
            $sql = "SELECT * FROM `student` WHERE sid LIKE '%$sidlike%' AND fname LIKE '%$fnamelike%' AND lname LIKE '%$lnamelike%' AND snumber LIKE '%$snumberlike%' AND department LIKE '%$departmentlike%'  AND birthdate LIKE '%$birthdatelike%'    ORDER BY $colname    $asc  LIMIT $limitnumber , 5 ";
            $result = $mysqli->query($sql);
            $output = mysqli_fetch_all($result, MYSQLI_ASSOC);
            // pagination
            $result2 = $mysqli->query("SELECT COUNT('sid') FROM `student`");
            $row2 = $result2->fetch_row();
            $arraylenght = $row2[0];
            if ($arraylenght % 5 === 0) {
                $arraylenght = (($arraylenght - ($arraylenght % 5)) / 5);
            } else {
                $arraylenght = (($arraylenght - ($arraylenght % 5)) / 5) + 1;
            }
            // theader foreach
            $arr = array(array('sid', 'id'), array('fname', 'ad'), array('lname', 'soyad'), array('snumber', 'ogrenci no'), array('department', 'bolum'), array('birthdate', 'dogumtarihi'),);
            ?>
            <div style="text-align: center; margin-left: auto;margin-right: auto;">

                <table style="width: 10%;" class="table table-hover">
                    <thead>
                        <tr><?php
                            for ($i = 0; $i < count($arr); $i++) {
                            ?>
                                <th><a href="index.php?op=listStudent&pagenumb=1&colname=<?php echo $arr[$i][0] ?>&asc=<?php echo $asc == 'ASC' ? 'DESC' : 'ASC' ?>&sidlike=<?php echo $sidlike ?>&fnamelike=<?php echo $fnamelike ?>&lnamelike=<?php echo $lnamelike ?>&snumberlike=<?php echo $snumberlike ?>&departmentlike=<?php echo $departmentlike ?>&birthdatelike=<?php echo $birthdatelike ?>"><?php echo $arr[$i][1] ?></a></th>
                            <?php
                            }
                            ?><form action="" method="GET">
                                <input type="hidden" name="op" id="op" value="add">
                                <th><button type="submit" class="btn btn-warning"> Yeni</button></th>
                            </form>
                            <th></th>
                        </tr>
                    </thead>
                    <!-- filter -->
                    <tbody>
                        <tr>
                            <form action="" method="GET">
                                <td><input style="width: 75px;" type="text" class="form-control" name="sidlike" placeholder="filtrele" value="<?php echo $sidlike ?>"></td>
                                <td><input style="width: 120px;" type="text" class="form-control" name="fnamelike" placeholder="filtrele" value="<?php echo $fnamelike ?>"></td>
                                <td><input style="width: 120px;" type="text" class="form-control" name="lnamelike" placeholder="filtrele" value="<?php echo $lnamelike ?>"></td>
                                <td><input style="width: 120px;" type="text" class="form-control" name="snumberlike" placeholder="filtrele" value="<?php echo $snumberlike ?>"></td>
                                <td><input style="width: 120px;" type="text" class="form-control" name="departmentlike" placeholder="filtrele" value="<?php echo $departmentlike ?>"></td>
                                <td><input style="width: 140px;" type="date" class="form-control" name="birthdatelike" placeholder="filtrele" value="<?php echo $birthdatelike ?>"></td>
                                <td><button style="width: 140px;" class="btn btn-success" type="submit">Filtreleri Uygula</button></td>
                                <td><button style="width: 140px;" class="btn btn-danger" type="submit"><a style="color: white;" href="index.php">Sayfayı Temizle</a></button></td>
                            </form>
                        </tr>
                    <!-- datas -->
                        <?php
                        foreach ($output as $data) {
                        ?>
                            <tr>
                                <td name=""><?php echo $data['sid'] ?? '-.-'; ?></td>
                                <td name=""><?php echo $data['fname'] ?? '-.-'; ?></td>
                                <td name=""><?php echo $data['lname'] ?? '-.-'; ?></td>
                                <td name=""><?php echo $data['snumber'] ?? '-.-'; ?></td>
                                <td name=""><?php echo $data['department'] ?? '-.-'; ?></td>
                                <td name=""><?php echo $data['birthdate'] ?? '-.-'; ?></td>
                                <th><a href="index.php?op=delete&thesid=<?php echo $data['sid'] ?>">Sil</a></th>
                                <th><a href="index.php?op=update&thesid=<?php echo $data['sid'] ?>">Güncelle</a></th>
                            </tr>
                        <?php
                        };
                        ?>
                    </tbody>
                </table>
                <!-- pagination -->
                <div class="col-md-3 mb-3"></div>
                <div class="col-md-6 mb-3" style="margin-left: auto;margin-right: auto; padding-right: 50px;">
                    <div style="text-align: center;">
                        <nav aria-label="...">
                            <ul class="pagination" style="margin-left: auto; margin-right: auto;">
                                <li class="page-item"><a class="page-link" href="index.php?op=listStudent&pagenumb=<?php echo 1 ?>&colname=<?php echo $colname ?>&asc=<?php echo $asc ?>&sidlike=<?php echo $sidlike ?>&fnamelike=<?php echo $fnamelike ?>&lnamelike=<?php echo $lnamelike ?>&snumberlike=<?php echo $snumberlike ?>&departmentlike=<?php echo $departmentlike ?>&birthdatelike=<?php echo $birthdatelike ?>"><?php echo '<<<' ?></a></li>
                                <?php if ($pagenumb  - 1 > 0 and $pagenumb  - 1 <= $arraylenght) { ?><li class="page-item"><a class="page-link" href="index.php?op=listStudent&pagenumb=<?php echo $pagenumb - 1 ?>&colname=<?php echo $colname ?>&asc=<?php echo $asc ?>&sidlike=<?php echo $sidlike ?>&fnamelike=<?php echo $fnamelike ?>&lnamelike=<?php echo $lnamelike ?>&snumberlike=<?php echo $snumberlike ?>&departmentlike=<?php echo $departmentlike ?>&birthdatelike=<?php echo $birthdatelike ?>"><?php echo 'önceki' ?></a></li><?php } else { ?> <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">önceki</a></li> <?php } ?>
                                <?php if ($pagenumb  - 2 > 0 and $pagenumb  - 2 <= $arraylenght) { ?><li class="page-item"><a class="page-link" href="index.php?op=listStudent&pagenumb=<?php echo $pagenumb - 2 ?>&colname=<?php echo $colname ?>&asc=<?php echo $asc ?>&sidlike=<?php echo $sidlike ?>&fnamelike=<?php echo $fnamelike ?>&lnamelike=<?php echo $lnamelike ?>&snumberlike=<?php echo $snumberlike ?>&departmentlike=<?php echo $departmentlike ?>&birthdatelike=<?php echo $birthdatelike ?>"><?php echo $pagenumb - 2 ?></a></li><?php } ?>
                                <?php if ($pagenumb  - 1 > 0 and $pagenumb  - 1 <= $arraylenght) { ?><li class="page-item"><a class="page-link" href="index.php?op=listStudent&pagenumb=<?php echo $pagenumb - 1 ?>&colname=<?php echo $colname ?>&asc=<?php echo $asc ?>&sidlike=<?php echo $sidlike ?>&fnamelike=<?php echo $fnamelike ?>&lnamelike=<?php echo $lnamelike ?>&snumberlike=<?php echo $snumberlike ?>&departmentlike=<?php echo $departmentlike ?>&birthdatelike=<?php echo $birthdatelike ?>"><?php echo $pagenumb - 1 ?></a></li><?php } ?>
                                <li class="page-item active"><a class="page-link" href="index.php?op=listStudent&pagenumb=<?php echo $pagenumb                                                                   ?>&colname=<?php echo $colname ?>&asc=<?php echo $asc ?>&sidlike=<?php echo $sidlike ?>&fnamelike=<?php echo $fnamelike ?>&lnamelike=<?php echo $lnamelike ?>&snumberlike=<?php echo $snumberlike ?>&departmentlike=<?php echo $departmentlike ?>&birthdatelike=<?php echo $birthdatelike ?>"><?php echo $pagenumb     ?><span class="sr-only">(current)</span></a></li>
                                <?php if ($pagenumb  + 1 > 0 and $pagenumb  + 1 <= $arraylenght) { ?><li class="page-item"><a class="page-link" href="index.php?op=listStudent&pagenumb=<?php echo $pagenumb + 1 ?>&colname=<?php echo $colname ?>&asc=<?php echo $asc ?>&sidlike=<?php echo $sidlike ?>&fnamelike=<?php echo $fnamelike ?>&lnamelike=<?php echo $lnamelike ?>&snumberlike=<?php echo $snumberlike ?>&departmentlike=<?php echo $departmentlike ?>&birthdatelike=<?php echo $birthdatelike ?>"><?php echo $pagenumb + 1 ?></a></li><?php } ?>
                                <?php if ($pagenumb  + 2 > 0 and $pagenumb  + 2 <= $arraylenght) { ?><li class="page-item"><a class="page-link" href="index.php?op=listStudent&pagenumb=<?php echo $pagenumb + 2 ?>&colname=<?php echo $colname ?>&asc=<?php echo $asc ?>&sidlike=<?php echo $sidlike ?>&fnamelike=<?php echo $fnamelike ?>&lnamelike=<?php echo $lnamelike ?>&snumberlike=<?php echo $snumberlike ?>&departmentlike=<?php echo $departmentlike ?>&birthdatelike=<?php echo $birthdatelike ?>"><?php echo $pagenumb + 2 ?></a></li><?php } ?>
                                <?php if ($pagenumb  + 1 > 0 and $pagenumb  + 1 <= $arraylenght) { ?><li class="page-item"><a class="page-link" href="index.php?op=listStudent&pagenumb=<?php echo $pagenumb + 1 ?>&colname=<?php echo $colname ?>&asc=<?php echo $asc ?>&sidlike=<?php echo $sidlike ?>&fnamelike=<?php echo $fnamelike ?>&lnamelike=<?php echo $lnamelike ?>&snumberlike=<?php echo $snumberlike ?>&departmentlike=<?php echo $departmentlike ?>&birthdatelike=<?php echo $birthdatelike ?>"><?php echo 'sonraki' ?></a></li><?php } else { ?><li class="page-item disabled"><a class="page-link" href="#" tabindex="-1">sonraki</a></li> <?php }  ?>
                                <li class="page-item"><a class="page-link" href="index.php?op=listStudent&pagenumb=<?php echo $arraylenght  ?>&colname=<?php echo $colname ?>&asc=<?php echo $asc ?>&sidlike=<?php echo $sidlike ?>&fnamelike=<?php echo $fnamelike ?>&lnamelike=<?php echo $lnamelike ?>&snumberlike=<?php echo $snumberlike ?>&departmentlike=<?php echo $departmentlike ?>&birthdatelike=<?php echo $birthdatelike ?>"><?php echo '>>>' ?></a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-md-3 mb-3"></div>

            </div>


        </div>
    <?php }

    // pagehead
    function pageHead()
    {
    ?>

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <!-- linkler https://getbootstrap.com/docs/4.1/getting-started/introduction/ -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

            <script></script>

            <title>StudentWebApp</title>
        </head>
    <?php
    }
    ?>
    </div>
</body>

</html>