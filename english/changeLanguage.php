<?php
    function changeLanguageDropDown()
    {
        $url = $_SERVER['REQUEST_URI'];

        echo '<label for="language">Language:</label>';

        echo '<select name="language" id="language" onchange="changeLanguage()">';
        echo '<option value="indonesian"' . (strpos($url, "indonesian")!==false ? ' selected ' : '' ) . '>Indonesian</option>';
        echo '<option value="english"'. (strpos($url, "english")!==false ? ' selected ' : '' ) .'>English</option>';
        echo '</select>';
    }
?>

<script>
    let languages = ['english', 'indonesian'];

    function detectLanguage(url)
    {
        if(url.indexOf("indonesian") >= 0)
        {
            return "indonesian";
        }
        else if(url.indexOf("english") >= 0)
        {
            return "english";
        }

    }
    function changeLanguage()
    {
        let url = window.location.href;
        let currentLanguage = detectLanguage(url);
        let selectedLanguage = document.getElementById('language').value;
        let newUrl = url.replace(currentLanguage, selectedLanguage);
        window.location.href = newUrl;
    }
</script>