<?php
session_start();
$db = new SQLite3('/var/www/html/XSS_scenario/scenario.db');
//db->exec("CREATE TABLE IF NOT EXISTS photo(id INTEGER NOT NULL PRIMARY KEY, title TEXT, caption TEXT, loc TEXT);");

$uploaddir = "/var/www/html/XSS_scenario/upload/";
if (isset($_POST['title'])) {
  $title = $_POST['title'];
  $caption = $_POST['caption'];
  $uploaded_file = $uploaddir . basename($_FILES['photo']['name']);
  print_r($_FILES['photo']['tmp_name']);
  //die();
  move_uploaded_file($_FILES['photo']['tmp_name'], $uploaded_file);
  chmod($uploaded_file, 0777);
  print_r($_FILES);

  //record in db
  $insert = $db->prepare("INSERT INTO photo(title, caption, loc) VALUES (?, ?, ?);");
  $insert->bindParam(1, $title);
  $insert->bindParam(2, $caption);
  $insert->bindParam(3, basename($_FILES['photo']['name']));
  $insert->execute();
}
?>

<head>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <form enctype="multipart/form-data" action="upload.php" method="POST" class="w-full max-w-lg m-3">
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">
            Title
        </label>
        <input name="title" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-red-500 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white" id="grid-first-name" type="text" placeholder="Jane">
        <p class="text-red-500 text-xs italic">Please fill out this field.</p>
        </div>
    </div>
    <div class="flex justify-center">
        <div class="mb-3 xl:w-96">
          <label for="exampleFormControlTextarea1" class="form-label inline-block mb-2 text-gray-700"
            >Caption</label
          >
          <textarea name="caption"
            class="
              form-control
              block
              w-full
              px-3
              py-1.5
              text-base
              font-normal
              text-gray-700
              bg-white bg-clip-padding
              border border-solid border-gray-300
              rounded
              transition
              ease-in-out
              m-0
              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none
            "
            id="exampleFormControlTextarea1"
            rows="3"
            placeholder="Your caption"
          ></textarea>
        </div>
      </div>
    <div class="flex flex-wrap -mx-3 mb-2">
        <div class="flex justify-center">
            <div class="mb-3 w-96">
              <label for="formFile" class="form-label inline-block mb-2 text-gray-700">Upload Photo</label>
              <input name="photo" class="form-control 
              block
              w-full
              px-3
              py-1.5
              text-base
              font-normal
              text-gray-700
              bg-white bg-clip-padding
              border border-solid border-gray-300
              rounded
              transition
              ease-in-out
              m-0
              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none" type="file" id="formFile">
            </div>
          </div>
    </div>
    <input type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
    </input>
    </form>
</body>