import 'dart:convert';
import 'dart:io';
import 'package:flutter/material.dart';
import 'package:petcareapplication/screen/changepassword.dart';
import 'package:petcareapplication/screen/viewcamera.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:petcareapplication/api_provider.dart';

class MainMenuScreen extends StatefulWidget {

  final String Username;
  MainMenuScreen({this.Username});

  @override
  State<MainMenuScreen> createState() => _MainMenuScreenState();
}

class _MainMenuScreenState extends State<MainMenuScreen> {

  ApiProvider apiProvider = ApiProvider();

  String user;
  int room;

  Future doLogout() async {
    SharedPreferences preferences = await SharedPreferences.getInstance();
    preferences.clear();
    exit(0);
  }

  Future getInfo() async {
    try {
      SharedPreferences pref = await SharedPreferences.getInstance();
      String token = pref.getString('token');
      String Username = widget.Username;

      var rs = await apiProvider.getInfo(token, Username);

      if (rs.statusCode == 200) {
        print(rs.body);
        var jsonRes = jsonDecode(rs.body);

        if (jsonRes['ok']) {
          setState(() {
            user = jsonRes['info']['customerfirstname'];
            room = jsonRes['info']['room'];
          });
        } else {
          print(jsonRes['error']);
        }
      } else {
        print('Server error!');
      }
    } catch (error) {
      print(error);
    }
  }

  @override
  void initState() {
    super.initState();
    getInfo();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Pet Care"),
      ),
      body: Padding(
        padding: const EdgeInsets.fromLTRB(20, 50, 20, 0),
        child: SingleChildScrollView(
          child: Column(
            children: [
              Image.asset("assets/images/logo.png"),
              SizedBox(
                width: double.infinity,
                child: ElevatedButton.icon(
                  icon: Icon(Icons.desktop_windows),
                  label: Text("ดูสัตว์เลี้ยง", style: TextStyle(fontSize: 20)),
                  onPressed: () {
                    Navigator.push(context,
                        MaterialPageRoute(builder: (context) {
                      return ViewCameraScreen(roomDetail: room);
                    }));
                  },
                ),
              ),
              SizedBox(
                width: double.infinity,
                child: ElevatedButton.icon(
                  icon: Icon(Icons.lock),
                  label:
                      Text("เปลี่ยนรหัสผ่าน", style: TextStyle(fontSize: 20)),
                  onPressed: () {
                    Navigator.push(context,
                        MaterialPageRoute(builder: (context) {
                      return ChangePassworsScreen(sendUsername: widget.Username);
                    }));
                  },
                ),
              ),
              SizedBox(
                width: double.infinity,
                child: ElevatedButton.icon(
                  icon: Icon(Icons.lock),
                  label:
                      Text("Log out", style: TextStyle(fontSize: 20)),
                  onPressed: () => doLogout(),
                ),
              )
            ],
          ),
        ),
      ),
    );
  }
}
