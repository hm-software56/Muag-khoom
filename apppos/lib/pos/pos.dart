import 'dart:convert';
import 'dart:developer';

import 'package:apppos/pos/payment.dart';
import 'package:dio/dio.dart';
import 'package:flutter/services.dart';
import 'package:intl/intl.dart';
import '../login/login.dart';
import '../pos/menu.dart';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../config.dart';
import 'package:loading_animations/loading_animations.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter_barcode_scanner/flutter_barcode_scanner.dart';

class Pos extends StatefulWidget {
  @override
  _PosState createState() => _PosState();
}

class _PosState extends State<Pos> {
  var loginData;
  /*========== Function Check Logged user ================*/
  Future<SharedPreferences> _prefs = SharedPreferences.getInstance();
  Future<Null> checklogged() async {
    final SharedPreferences prefs = await _prefs;
    int login_id = prefs.getInt('login_id');
    if (login_id == null) {
      Navigator.of(context).pushAndRemoveUntil(
        // the new route
        MaterialPageRoute(
          builder: (BuildContext context) => LoginScreen(),
        ),
        (Route route) => false,
      );
      /*Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => LoginScreen()),
      );*/
      /*Navigator.pushReplacement(
          context, MaterialPageRoute(builder: (context) => LoginScreen()));*/
    } else {
      setState(() {
        loginData = jsonDecode(prefs.getString('logindata'));
      });
    }
  }

  /*==========Function Load products API ================*/
  var data;
  bool laoding = true;
  Future<String> LoadProducts() async {
    final SharedPreferences prefs = await _prefs;
    var login_Data = prefs.getString('logindata');
    var branch_id;
    if (login_Data != null) {
      var login_Data = jsonDecode(prefs.getString('logindata'));
      branch_id = login_Data['0']['branch_id'];
    }
    //var login_Data = jsonDecode(prefs.getString('logindata'));
    var dio = Dio();
    var formData = FormData.fromMap({
      //'keyword': Null,
      'branch_id': branch_id
    });
    try {
      Response response =
          await dio.post('${ip_api}api-product/sale', data: formData);
      if (response.statusCode == 200) {
        setState(() {
          data = response.data;
          laoding = false;
        });
      }
    } on DioError catch (e) {
      Alert(Icons.done, Colors.white, e.message, Colors.red);
      //print('Make sure your server runing');
    }
  }

  /** ===========Search Product by Keyword ================== */
  TextEditingController _SearchBarFieldController = TextEditingController();
  String Keyword;
  bool laodingsearch = false;
  Future<String> SearchProducts() async {
    final SharedPreferences prefs = await _prefs;
    var login_Data = prefs.getString('logindata');
    var branch_id;
    if (login_Data != null) {
      var login_Data = jsonDecode(prefs.getString('logindata'));
      branch_id = login_Data['0']['branch_id'];
    }
    var dio = Dio();
    var formData =
        FormData.fromMap({'keyword': Keyword, 'branch_id': branch_id});
    setState(() {
      laodingsearch = true;
    });
    try {
      Response response =
          await dio.post('${ip_api}api-product/sale', data: formData);
      if (response.statusCode == 200) {
        print(response.data);
        setState(() {
          data = response.data;
          laodingsearch = false;
        });
      }
    } on DioError catch (e) {
      Alert(Icons.done, Colors.white, e.message, Colors.red);
      //print('Make sure your server runing');
    }
  }

  /** =============== Scanbarcode =================== */

  // Platform messages are asynchronous, so we initialize in an async method.
  var _scanBarcode;
  Future<void> scanBarcodeNormal() async {
    String barcodeScanRes;
    // Platform messages may fail, so we use a try/catch PlatformException.
    try {
      barcodeScanRes = await FlutterBarcodeScanner.scanBarcode(
          '#ff6666', 'ຍົກເລິກ', true, ScanMode.BARCODE);
      print(barcodeScanRes);
    } on PlatformException {
      barcodeScanRes = 'Failed to get platform version.';
      Alert(Icons.warning, Colors.white, barcodeScanRes, Colors.green);
    }
    if (!mounted) return;
    if (barcodeScanRes.length > 3) {
      final SharedPreferences prefs = await _prefs;
      var login_Data = prefs.getString('logindata');
      var branch_id;
      if (login_Data != null) {
        var login_Data = jsonDecode(prefs.getString('logindata'));
        branch_id = login_Data['0']['branch_id'];
      }
      var dio = Dio();
      var formData =
          FormData.fromMap({'barcode': barcodeScanRes, 'branch_id': branch_id});
      try {
        Response response =
            await dio.post('${ip_api}api-product/sale', data: formData);
        if (response.statusCode == 200) {
          int prod_id;
          for (var data_barcode in response.data) {
            prod_id = data_barcode['id'];
          }
          print(response.data);
          if (response.data.isEmpty) {
            Alert(Icons.warning, Colors.white,
                'ສີນຄ້າໃນລະບົບບໍ່ມີລະຫັດບາໂຄດນີ້.!', Colors.red);
          } else {
            AddCard(prod_id, response.data);
            Alert(Icons.done, Colors.white, 'ເອົາສີນຄ້າເຂົ້າກະຕ່າແລ້ວ.!',
                Colors.green);
          }
        }
      } on DioError catch (e) {
        Alert(Icons.done, Colors.white, e.message, Colors.red);
      }
    } else {
      Alert(Icons.warning, Colors.white, 'ຍົກເລິກສະແກນບາໂຄດ', Colors.red);
    }
  }

  /* ============ Function Add Order Into Card ===========*/
  List<Map> added_items = [];
  int count_add_items = 0;
  int price_total = 0;
  Future<String> AddCard(int proid, productData) async {
    productData.map((item) {
      if (proid == item["id"]) {
        //print(item);
        Map added;
        int price_by_qtt;
        bool empty_qtt = false;
        if (added_items.length > 0) {
          int i = 0;
          for (Map added_item in added_items) {
            i = i + 1;
            if (proid == added_item["id"]) {
              price_by_qtt =
                  int.parse(item['pricesale']) * (added_item['qautity'] + 1);

              if (item['qautity'] > added_item['qautity']) {
                price_total = price_total + int.parse(item['pricesale']);
                added_items.removeAt(i - 1);
                added = {
                  'id': added_item['id'],
                  'name': added_item['name'],
                  'price': price_by_qtt.toString(),
                  'qautity': added_item['qautity'] + 1
                };
              } else {
                empty_qtt = true;
                Alert(Icons.warning, Colors.white, 'ສີນຄ້າຂອງທ່ານໝົດແລ້ວ.!',
                    Colors.red);
              }
              break;
            } else {
              if (item['qautity'] > 0) {
                price_total = price_total + int.parse(item['pricesale']);
                added = {
                  'id': item['id'],
                  'name': item['name'],
                  'price': item['pricesale'],
                  'qautity': 1
                };
              } else {
                empty_qtt = true;
                Alert(Icons.warning, Colors.white, 'ສີນຄ້າຂອງທ່ານໝົດແລ້ວ.!',
                    Colors.red);
              }
            }
          }
        } else {
          if (item['qautity'] > 0) {
            price_total = price_total + int.parse(item['pricesale']);
            added = {
              'id': item['id'],
              'name': item['name'],
              'price': item['pricesale'],
              'qautity': 1
            };
          } else {
            empty_qtt = true;
            Alert(Icons.warning, Colors.white, 'ສີນຄ້າຂອງທ່ານໝົດແລ້ວ.!',
                Colors.red);
          }
        }
        setState(() {
          if (empty_qtt == false) {
            added_items.insert(0, added);
            count_add_items = added_items.length;
            price_total = price_total;
          }
        });
      }
    }).toList();
  }

  /*================= Function Remove echo order item =========*/
  Future<String> RemoveToCard(int proid) async {
    int i = 0;
    for (Map added_item in added_items) {
      i = i + 1;
      if (proid == added_item["id"]) {
        price_total = price_total - int.parse(added_item['price']);
        added_items.removeAt(i - 1);
        setState(() {
          added_items = added_items;
          count_add_items = added_items.length;
          price_total;
        });
        Alert(
            Icons.done, Colors.white, 'ທ່ານໄດ້ລຶບລາຍການອອກແລ້ວ.!', Colors.red);
        break;
      }
    }
  }

  /*============== Function Remove all Order ===============*/
  Future<String> RemoveAll() async {
    added_items.clear();
    setState(() {
      added_items = added_items;
      count_add_items = added_items.length;
      price_total = 0;
    });
    Alert(Icons.done, Colors.white, 'ທ່ານໄດ້ລຶບລາຍການອອກທັງໝົດແລ້ວ!.',
        Colors.red);
  }

  /*======== Alert msg ==============*/
  void Alert(IconData icon, Color iconcolor, var msg, Color bgcolor) {
    ScaffoldMessenger.of(context).showSnackBar(SnackBar(
      content: Row(
        children: <Widget>[
          Icon(
            icon,
            color: iconcolor,
          ),
          Text(
            msg,
            style: TextStyle(fontFamily: 'Phetsarath OT'),
          ),
        ],
      ),
      backgroundColor: bgcolor,
      duration: Duration(milliseconds: 1500),
    ));
  }

  /*============= Function Popup input discount===============*/
  TextEditingController _textFieldController = TextEditingController();
  int discount = 0;
  Future<void> DiscountTextInputDialog(BuildContext context) async {
    return showDialog(
        context: context,
        builder: (context) {
          return AlertDialog(
            title: Text(
              'ສ່ວນຫລຸດ',
              style: TextStyle(fontFamily: 'Phetsarath OT'),
            ),
            content: TextField(
              keyboardType: TextInputType.number,
              onChanged: (value) {
                setState(() {
                  discount = int.parse(value);
                });
              },
              controller: _textFieldController,
              decoration: InputDecoration(hintText: "ປ້ອນສ່ວນຫລຸດ"),
            ),
            actions: <Widget>[
              FlatButton(
                color: Colors.green,
                textColor: Colors.white,
                child: Text('OK'),
                onPressed: () {
                  setState(() {
                    Navigator.pop(context);
                  });
                },
              ),
            ],
          );
        });
  }

  /** ========= Function Refresh page ============= */
  Future<void> _pullRefresh() async {
    LoadProducts();
  }

  @override
  void initState() {
    super.initState();
    checklogged();
    LoadProducts();
  }

  Widget build(BuildContext context) {
    print(Keyword);
    return new Scaffold(
      drawer: Menu(loginData),
      appBar: new AppBar(
        title: const Text('POS'),
        actions: <Widget>[
          Padding(
            padding: const EdgeInsets.fromLTRB(0, 10, 0, 10),
            child: SizedBox(
              width: MediaQuery.of(context).size.width * 0.65,
              child: TextField(
                onChanged: (value) {
                  setState(() {
                    Keyword = value;
                  });
                  SearchProducts();
                },
                controller: _SearchBarFieldController,
                decoration: InputDecoration(
                  hintText: "ຄົ້ນຫາ​",
                  fillColor: Colors.white,
                  filled: true,
                  isDense: true,
                  contentPadding: EdgeInsets.all(8),
                  border: OutlineInputBorder(),
                  focusedBorder: InputBorder.none,
                  enabledBorder: InputBorder.none,
                  errorBorder: InputBorder.none,
                  disabledBorder: InputBorder.none,
                  suffixIcon: Icon(Icons.search),
                ),
              ),
            ),
          ),
          IconButton(
            icon: const Icon(Icons.qr_code_2_rounded),
            tooltip: 'View Orders',
            onPressed: () {
              //startBarcodeScanStream();
              scanBarcodeNormal();
            },
          ),
        ],
      ),
      body: RefreshIndicator(
        onRefresh: _pullRefresh,
        child: Container(
          child: laoding
              ? LoadingFlipping.circle()
              : Column(
                  mainAxisAlignment: MainAxisAlignment.spaceEvenly,
                  children: [
                    Container(
                      height: count_add_items > 4 ? 150 : null,
                      child: SingleChildScrollView(
                        child: Column(
                          children: [
                            for (var order_item in added_items)
                              Row(
                                children: [
                                  Expanded(
                                    child: Padding(
                                        padding:
                                            EdgeInsets.fromLTRB(10, 10, 10, 0),
                                        child: Align(
                                          alignment: Alignment.bottomLeft,
                                          child: SizedBox(
                                            width: 25.0,
                                            height: 25.0,
                                            child: FloatingActionButton(
                                                onPressed: () {
                                                  RemoveToCard(
                                                      order_item['id']);
                                                },
                                                tooltip: 'Remove',
                                                backgroundColor: Colors.red,
                                                child: Icon(
                                                  Icons.remove_outlined,
                                                  size: 15,
                                                  color: Colors.white,
                                                )),
                                          ),
                                        )),
                                  ),
                                  Expanded(
                                    child: Padding(
                                      padding:
                                          EdgeInsets.fromLTRB(0, 10, 10, 0),
                                      child: Text(
                                        '${order_item['name']}',
                                        maxLines: 1,
                                        overflow: TextOverflow.ellipsis,
                                        softWrap: false,
                                      ),
                                    ),
                                  ),
                                  Expanded(
                                    child: Center(
                                      child: Padding(
                                        padding:
                                            EdgeInsets.fromLTRB(0, 10, 10, 0),
                                        child: Text('${order_item['qautity']}'),
                                      ),
                                    ),
                                  ),
                                  Expanded(
                                    child: Padding(
                                      padding:
                                          EdgeInsets.fromLTRB(0, 10, 10, 0),
                                      child: Align(
                                        alignment: Alignment.bottomRight,
                                        child: Text(
                                          '${NumberFormat.currency(locale: 'eu', symbol: '').format(int.parse(order_item['price']))}',
                                        ),
                                      ),
                                    ),
                                  ),
                                ],
                              ),
                          ],
                        ),
                      ),
                    ),
                    if (count_add_items > 0) Divider(),
                    if (count_add_items > 0)
                      Column(
                        children: [
                          Padding(
                            padding: const EdgeInsets.fromLTRB(8, 0, 8, 0),
                            child: Align(
                              alignment: Alignment.bottomRight,
                              child: Text(
                                  'ລວມຈຳນວນເງີນ: ${NumberFormat.currency(locale: 'eu', symbol: '').format(price_total)}'),
                            ),
                          ),
                          Padding(
                            padding: const EdgeInsets.fromLTRB(8, 10, 8, 10),
                            child: Align(
                              alignment: Alignment.bottomRight,
                              child: GestureDetector(
                                onTap: () {
                                  DiscountTextInputDialog(context);
                                },
                                child: new Text(
                                    "ສ່ວນຫລຸດ: ${NumberFormat.currency(locale: 'eu', symbol: '').format(discount)}"),
                              ),
                            ),
                          ),
                        ],
                      ),
                    if (count_add_items > 0)
                      Row(
                        children: [
                          Padding(
                            padding: const EdgeInsets.fromLTRB(8, 0, 8, 0),
                            child: RaisedButton.icon(
                              icon: Icon(Icons.payment_outlined),
                              textColor: Colors.white,
                              color: Colors.green,
                              label: const Text('ຈ່າຍເງີນ'),
                              onPressed: () {
                                Navigator.push(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) => Payment(added_items,
                                          discount, price_total, loginData)),
                                );
                              },
                            ),
                          ),
                          Expanded(
                            child: Text(''),
                          ),
                          Padding(
                            padding: const EdgeInsets.fromLTRB(8, 0, 8, 0),
                            child: Align(
                              alignment: Alignment.bottomRight,
                              child: RaisedButton(
                                onPressed: () {
                                  RemoveAll();
                                },
                                color: Colors.red,
                                textColor: Colors.white,
                                child: Row(
                                  children: <Widget>[
                                    Icon(Icons.delete_forever),
                                    Text('ຍົກເລີກ')
                                  ],
                                ),
                              ),
                            ),
                          )
                        ],
                      ),
                    if (count_add_items > 0) Divider(),
                    laodingsearch
                        ? CircularProgressIndicator.adaptive()
                        : Expanded(
                            child: GridView.count(
                              crossAxisCount: 2,
                              //mainAxisSpacing: 4.0,
                              //crossAxisSpacing: 2.0,
                              //padding: const EdgeInsets.all(0.0),
                              children: <Widget>[
                                for (var item in data)
                                  new GridTile(
                                      header: Container(
                                        padding:
                                            EdgeInsets.fromLTRB(10, 0, 0, 20),
                                        margin:
                                            EdgeInsets.fromLTRB(4, 11, 10, 10),
                                        child: Align(
                                            alignment: Alignment.topRight,
                                            child: Text(
                                              '${item['qautity']}',
                                              style: TextStyle(
                                                  backgroundColor: Colors.black,
                                                  color: Colors.white),
                                            )),
                                      ),
                                      child: Container(
                                        padding:
                                            EdgeInsets.fromLTRB(0, 5, 5, 0),
                                        child: new Card(
                                          color: Colors.white,
                                          child: InkResponse(
                                            enableFeedback: true,
                                            borderRadius:
                                                BorderRadius.circular(10),
                                            child: ClipRRect(
                                              borderRadius:
                                                  BorderRadius.circular(8.0),
                                              child: CachedNetworkImage(
                                                imageUrl:
                                                    '${ip}/images/thume/${item['image']}',
                                                fit: BoxFit.cover,
                                                placeholder: (context, url) =>
                                                    CircularProgressIndicator(),
                                                errorWidget:
                                                    (context, url, error) =>
                                                        Icon(Icons.error),
                                              ),
                                            ),
                                            onTap: () =>
                                                {AddCard(item['id'], data)},
                                          ),
                                        ),
                                      ),
                                      footer: Container(
                                        padding:
                                            EdgeInsets.fromLTRB(10, 0, 10, 5),
                                        margin: EdgeInsets.fromLTRB(4, 0, 9, 0),
                                        color: Colors.black,
                                        child: Center(
                                            child: Column(
                                          children: [
                                            Text('${item['name']}',
                                                maxLines: 1,
                                                overflow: TextOverflow.clip,
                                                softWrap: false,
                                                style: TextStyle(
                                                    color: Colors.white)),
                                            Text(
                                                '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(int.parse(item['pricesale']))}',
                                                maxLines: 1,
                                                overflow: TextOverflow.clip,
                                                softWrap: false,
                                                style: TextStyle(
                                                    color: Colors.red)),
                                          ],
                                        )),
                                      ))
                              ],
                            ),
                          ),
                  ],
                ),
          padding: const EdgeInsets.all(0.0),
          alignment: Alignment.center,
        ),
      ),
    );
  }
}
