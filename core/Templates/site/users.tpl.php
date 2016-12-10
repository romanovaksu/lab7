{% extends "layout.tpl.php" %}
{% block content %}
<h2>Пользователи </h2>
<table class="table table-bordered"> 
    <thead> 
        <tr> 
            <th>#</th> 
            <th>Name</th>
            <th>Info</th> 
        </tr> 
    </thead> 
    <tbody> 
        {% for user in users %}
        <tr> 
            <th scope="row">{{user.id}}</th><td>{{user.name}}</td><td>{{user.info}}</td> </tr> 
        <tr> 
        {% endfor %}
   </tbody> 
</table>
{% endblock %}