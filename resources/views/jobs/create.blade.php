<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Job</title>
</head>

<body>
    <h1>Create New Job</h1>
    <form action="/jobs" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Job Title">
        <input type="text" name="description" placeholder="Job Description">
        <button type="submit">Create Job</button>
    </form>
</body>

</html>