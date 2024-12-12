<?php
require "../../config/config.php";

// Tüm akademisyenleri getir
$query = "SELECT id, department_id FROM academics";
$result = mysqli_query($connection, $query);
$academics = mysqli_fetch_all($result, MYSQLI_ASSOC);

if ($result) {
    foreach ($academics as $academic) {
        $academic_id = $academic['id'];
        $department_id = $academic['department_id'];

        // Akademisyenin bölümüne uygun dersleri bul
        $course_query = "SELECT id FROM courses WHERE department_id = $department_id";
        $course_result = mysqli_query($connection, $course_query);
        $courses = mysqli_fetch_all($course_result, MYSQLI_ASSOC);

        if ($courses) {
            // Daha önce atanmış dersleri getir
            $assigned_query = "SELECT course_id FROM academics_courses WHERE academic_id = $academic_id";
            $assigned_result = mysqli_query($connection, $assigned_query);
            $assigned_courses = mysqli_fetch_all($assigned_result, MYSQLI_ASSOC);

            // Daha önce atanmış derslerin ID'lerini bir diziye dönüştür
            $assigned_course_ids = array_column($assigned_courses, 'course_id');

            // Atanmamış bir ders bulana kadar devam et
            $unassigned_course_found = false;
            while (!$unassigned_course_found && !empty($courses)) {
                // Rastgele bir ders seç
                $random_key = array_rand($courses);
                $random_course = $courses[$random_key];

                // Eğer ders atanmadıysa, atama yap
                if (!in_array($random_course['id'], $assigned_course_ids)) {
                    $course_id = $random_course['id'];

                    // Atamayı academics_courses tablosuna ekle
                    $insert_query = "INSERT INTO academics_courses (academic_id, course_id) VALUES ($academic_id, $course_id)";
                    mysqli_query($connection, $insert_query);

                    $unassigned_course_found = true;
                } else {
                    // Seçilen dersi listeden çıkar
                    unset($courses[$random_key]);
                }
            }
        }
    }

    echo "Ders atamaları başarıyla tamamlandı.";
} else {
    echo "Akademisyen bilgileri alınamadı.";
}
