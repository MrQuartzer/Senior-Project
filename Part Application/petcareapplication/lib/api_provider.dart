import 'package:http/http.dart' as http;
import 'dart:io';
import 'dart:async';

class ApiProvider{
  ApiProvider();
  
  String endPoint = 'http://192.168.0.99:3000';

  Future<http.Response> doLogin(String username, String password) async {
    String _url = '$endPoint/login';
    var body = {
      "username": username,
      "password": password
    };

    return http.post(Uri.parse(_url), body: body);
  }

   Future<http.Response> getInfo(String token, String username) async {
    String _url = '$endPoint/users/$username';

    return http.get(Uri.parse(_url), headers: {HttpHeaders.authorizationHeader: 'Bearer $token'});
  }

  Future<http.Response> getRoom(String token, String roomno) async {
    String _url = '$endPoint/room/$roomno';

    return http.get(Uri.parse(_url), headers: {HttpHeaders.authorizationHeader: 'Bearer $token'});
  }

  Future<http.Response> updatePassword(String token, String username, String password) async {
    String _url = '$endPoint/users/$username';
    var body = {
      "password": password
    };

    return http.put(Uri.parse(_url), body: body, headers: {HttpHeaders.authorizationHeader: 'Bearer $token'});
  }

}