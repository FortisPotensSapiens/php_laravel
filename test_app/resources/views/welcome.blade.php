<!DOCTYPE html>
<html>
<head>
    <title>Temporary file hoster.</title>
</head>
<body>
<pre>
<h1>Хранилище временных файлов</h1>
Максимальный размер файла 512 MiB
Время хранения файла 30 дней. 

<details id="uploading">
    <summary>Загрузка файла <code>POST / </code></summary>
Отправьте запрос POST  по адресу сайта с Content-Type: multipart/form-data и ключом для файла file. 
Например вот так в curl:

curl --location 'https://website.com' --form 'file=@"C:/test.txt"'

В ответ вернется в теле ответа путь для скачивания файла, а в заголовке X-Delete путь для удаления файла.
</details>

<details id="downloading">
    <summary>Скачивание файла <code>GET /file/{name}</code></summary>
Отправьте запрос GET с указанием имение файла по адресу /file/{name}. 
Например вот так в curl:

curl --location 'https://website.com/file/test.txt' 

В ответ вернется сам файл. 
</details>

<details id="deleting">
    <summary>Удаление файла <code>GET /delete/{name}</code></summary>
Отправьте запрос GET с указанием имение файла по адресу /delete/{name}. 
Например вот так в curl:

curl --location 'https://website.com/delete/test.txt'

В ответ вернется JSON 
<code> 
{
    "deleted": true
}</code>
в котором поле deleted указывает на то удален ли был файл или нет. 
</details>
</pre>
</body>
</html>