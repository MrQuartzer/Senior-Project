import 'dart:convert';

import 'package:flutter/material.dart';
import 'dart:async';
import 'package:petcareapplication/api_provider.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:petcareapplication/screen/camera.dart';

class ViewCameraScreen extends StatefulWidget {
  @override
  _ViewCameraScreenState createState() => _ViewCameraScreenState();

  final int roomDetail;
  ViewCameraScreen({this.roomDetail});
}

class _ViewCameraScreenState extends State<ViewCameraScreen> {

  ApiProvider apiProvider = ApiProvider();

  var urls = "192.168.0.7:5000";

  Future getRoom() async {
    try {
      SharedPreferences pref = await SharedPreferences.getInstance();
      String token = pref.getString('token');
      int roomno = widget.roomDetail;

      var rs = await apiProvider.getRoom(token, roomno.toString());

      if (rs.statusCode == 200) {
        print(rs.body);
        var jsonRes = jsonDecode(rs.body);

        if (jsonRes['ok']) {
          setState(() {
            url = jsonRes['info']['camera'];
            print("url = $url");
            print(url.runtimeType);
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

  String url;

  @override
  void initState() {
    super.initState();
    getRoom();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("ดูสัตว์เลี้ยง"),
      ),
      body: Padding(
        padding: const EdgeInsets.fromLTRB(20, 50, 20, 0),
        child: SingleChildScrollView(
          child: Column(
            children: [
              SizedBox(
                width: double.infinity,
                child: ElevatedButton.icon(
                  icon: Icon(Icons.desktop_windows),
                  label: Text("สัตว์เลี้ยงห้องที่ ${widget.roomDetail}", style: TextStyle(fontSize: 20)),
                  onPressed: () {
                    Navigator.push(context,
                        MaterialPageRoute(builder: (context) {
                      return CameraScreen(viewcamera: url);
                    }));
                  },
                ),
              ),
            ],
          ),
        ),
        )
    );
  }
}