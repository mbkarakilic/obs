<?php
require "../../config/config.php";

$id = $_POST["id"]; // Ders ID'si

// 1. Dersin isFinished durumunu güncelle
$query = "
    UPDATE courses 
    SET isFinished = 1
    WHERE id = $id
";
$result = mysqli_query($connection, $query);

if ($result) {
    // 2. Dersin sınavlarını ve ağırlıklarını al
    $exams_query = "SELECT id, percent FROM exams WHERE course_id = $id";
    $exams_result = mysqli_query($connection, $exams_query);

    $exam_data = [];
    while ($row = mysqli_fetch_assoc($exams_result)) {
        $exam_data[$row["id"]] = floatval($row["percent"]);
    }

    if (!empty($exam_data)) {
        // Her öğrenci için ders notlarını ve ortalamalarını hesapla
        $grades_query = "
            SELECT g.student_id, g.exam_id, g.grade
            FROM grades g
            WHERE g.exam_id IN (" . implode(',', array_keys($exam_data)) . ")
        ";
        $grades_result = mysqli_query($connection, $grades_query);

        $student_scores = []; // Her öğrenci için notlar ve ağırlıklar
        while ($row = mysqli_fetch_assoc($grades_result)) {
            $student_id = $row["student_id"];
            $exam_id = $row["exam_id"];
            $grade = doubleval($row["grade"]);
            $percent = $exam_data[$exam_id];

            if (!isset($student_scores[$student_id])) {
                $student_scores[$student_id] = [
                    "total_weighted_score" => 0.0,
                    "total_percent" => 0.0
                ];
            }

            $student_scores[$student_id]["total_weighted_score"] += $grade * ($percent / 100);
            $student_scores[$student_id]["total_percent"] += $percent;
        }

        // Öğrencilerin ders ortalamasını hesapla ve genel GPA güncelle
        foreach ($student_scores as $student_id => $scores) {
            // Ders ortalaması (yüzdelik ağırlık dikkate alınarak)
            $course_average = $scores["total_weighted_score"] / ($scores["total_percent"] / 100);

            // Öğrencinin bulunduğu dönem bilgisi (semester) alınır
            $semester_query = "
                SELECT semester 
                FROM students 
                WHERE id = $student_id
            ";
            $semester_result = mysqli_query($connection, $semester_query);
            $student_semester = mysqli_fetch_assoc($semester_result)["semester"];

            // Ders ortalamasını ve dönemi student_courses tablosuna kaydet
            $update_average_query = "
                UPDATE student_courses 
                SET average = $course_average, student_semester = $student_semester
                WHERE student_id = $student_id AND course_id = $id
            ";
            mysqli_query($connection, $update_average_query);

            // Dersin kredisi
            $course_query = "SELECT ects FROM courses WHERE id = $id";
            $course_result = mysqli_query($connection, $course_query);
            $course_credit = mysqli_fetch_assoc($course_result)["ects"];

            // Öğrenci dersi geçtiyse krediyi ekle
            if ($course_average >= 50) { // Geçme notu 50 (minimum D)
                $update_credit_query = "
                    UPDATE students 
                    SET total_ects = total_ects + $course_credit
                    WHERE id = $student_id
                ";
                mysqli_query($connection, $update_credit_query);
            }

            // Genel GPA'yı güncelle (yalnızca bitmiş dersleri hesaba katar)
            $overall_query = "
                SELECT 
                    SUM(sc.average * c.ects) / SUM(c.ects) AS weighted_average
                FROM student_courses sc
                INNER JOIN courses c ON sc.course_id = c.id
                WHERE sc.student_id = $student_id AND c.isFinished = 1
            ";
            $overall_result = mysqli_query($connection, $overall_query);
            $weighted_average = mysqli_fetch_assoc($overall_result)["weighted_average"];

            // 100 üzerinden ağırlıklı ortalamayı 4'lük sisteme çevir
            $gpa = ($weighted_average / 100) * 4;

            // Genel ortalamayı güncelle
            $update_gpa_query = "
                UPDATE students 
                SET gpa = $gpa
                WHERE id = $student_id
            ";
            mysqli_query($connection, $update_gpa_query);
        }
    } else {
        echo "Bu ders için sınav bulunamadı.";
    }

    // Başarı yanıtı
    $requestResult = array(
        "success" => true,
    );
} else {
    // Hata yanıtı
    $requestResult = array(
        "success" => false,
    );
}

echo json_encode($requestResult);
?>
