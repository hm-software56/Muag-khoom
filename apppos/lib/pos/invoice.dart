import 'dart:typed_data';
import 'package:apppos/pos/menu.dart';
import 'package:apppos/pos/pos.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:intl/intl.dart';
import 'package:esc_pos_utils/esc_pos_utils.dart';

class Invoice extends StatefulWidget {
  var data_validate;
  var invoiceData;
  List<Map> added_items;
  int discount;
  int price_total;
  var loginData;
  Invoice(this.added_items, this.discount, this.price_total, this.loginData,
      this.data_validate, this.invoiceData);
  @override
  _InvoiceState createState() => _InvoiceState(this.added_items, this.discount,
      this.price_total, this.loginData, this.data_validate, this.invoiceData);
}

class _InvoiceState extends State<Invoice> {
  var data_validate;
  var invoiceData;
  List<Map> added_items;
  int discount;
  int price_total;
  var loginData;
  _InvoiceState(this.added_items, this.discount, this.price_total,
      this.loginData, this.data_validate, this.invoiceData);

  Future<void> Testprint() async {
    final profile = await CapabilityProfile.load();
    final generator = Generator(PaperSize.mm80, profile);
    List<int> bytes = [];
    bytes += generator.text('Bold text', styles: PosStyles(bold: true));
    bytes += generator.text('Reverse text', styles: PosStyles(reverse: true));
    bytes += generator.text('Underlined text',
        styles: PosStyles(underline: true), linesAfter: 1);
    bytes +=
        generator.text('Align left', styles: PosStyles(align: PosAlign.left));
    bytes += generator.text('Align center',
        styles: PosStyles(align: PosAlign.center));
    bytes += generator.text('Align right',
        styles: PosStyles(align: PosAlign.right), linesAfter: 1);

    bytes += generator.row([
      PosColumn(
        text: 'col3',
        width: 3,
        styles: PosStyles(align: PosAlign.center, underline: true),
      ),
      PosColumn(
        text: 'col6',
        width: 6,
        styles: PosStyles(align: PosAlign.center, underline: true),
      ),
      PosColumn(
        text: 'col3',
        width: 3,
        styles: PosStyles(align: PosAlign.center, underline: true),
      ),
    ]);

    bytes += generator.text('Text size 200%',
        styles: PosStyles(
          height: PosTextSize.size2,
          width: PosTextSize.size2,
        ));
    bytes += generator.feed(2);
    bytes += generator.cut();
    return bytes;
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
        drawer: drawer,
        appBar: new AppBar(
          title: const Text(
            'ໃບຮັບເງີນ',
            style: TextStyle(fontFamily: 'Phetsarath OT'),
          ),
          actions: <Widget>[
            IconButton(
              icon: const Icon(Icons.shopping_cart),
              tooltip: 'View Orders',
              onPressed: () {
                Navigator.push(context, MaterialPageRoute<void>(
                  builder: (BuildContext context) {
                    return Scaffold(
                      appBar: AppBar(
                        title: const Text('Next page'),
                      ),
                      body: const Center(
                        child: Text(
                          'This is the next page',
                          style: TextStyle(fontSize: 24),
                        ),
                      ),
                    );
                  },
                ));
              },
            ),
            IconButton(
              icon: const Icon(Icons.logout),
              tooltip: 'Logout',
              onPressed: () {},
            ),
          ],
        ),
        body: Container(
          child: Padding(
            padding: EdgeInsets.fromLTRB(10, 10, 10, 10),
            child: SingleChildScrollView(
              child: Column(
                children: [
                  Row(
                    children: [
                      Expanded(child: Text('ລວມຈໍານວນເງິີນທັງໝົດ:')),
                      Expanded(
                          child: Text(
                              '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(price_total)}'))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​ເງ​ີນ​ສ່ວນຫຼຸດ:')),
                      Expanded(
                          child: Text(
                        '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(discount)}',
                        style: TextStyle(
                            fontWeight: FontWeight.bold, color: Colors.blue),
                      ))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ລວມ​ຈ​ຳ​ນວນ​ເງ​ີນ​ຕ້ອງ​ຈ່າຍ:')),
                      Expanded(
                          child: Text(
                        '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(price_total - discount)}',
                        style: TextStyle(fontWeight: FontWeight.bold),
                      ))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ(LAK):')),
                      Expanded(
                          child: data_validate['pay_lak'] == null
                              ? Text('0,00 ກີບ')
                              : Text(
                                  '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(data_validate['pay_lak'])}'))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ(TH):')),
                      Expanded(
                          child: data_validate['pay_th'] == null
                              ? Text('0,00 ບາດ')
                              : Text(
                                  '${NumberFormat.currency(locale: 'eu', symbol: 'ບາດ').format(data_validate['pay_th'])}'))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​ເງ​ີນ​ຈ່າຍ(USD):')),
                      Expanded(
                          child: data_validate['pay_usd'] == null
                              ? Text('0,00 ໂດລາ')
                              : Text(
                                  '${NumberFormat.currency(locale: 'eu', symbol: 'ໂດລາ').format(data_validate['pay_usd'])}'))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​​ເງີນຄ້າງ:')),
                      Expanded(
                          child: data_validate['pay_still'] == null
                              ? Text('0,00')
                              : Text(
                                  '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(data_validate['pay_still'])}',
                                  style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: Colors.red),
                                ))
                    ],
                  ),
                  Divider(),
                  Row(
                    children: [
                      Expanded(child: Text('ຈ​ຳ​ນວນ​​ເງີນທອນ:')),
                      Expanded(
                          child: data_validate['pay_change'] == null
                              ? Text('0,00')
                              : Text(
                                  '${NumberFormat.currency(locale: 'eu', symbol: 'ກີບ').format(data_validate['pay_change'])}',
                                  style: TextStyle(
                                      fontWeight: FontWeight.bold,
                                      color: Colors.green),
                                ))
                    ],
                  ),
                  Divider(
                    color: Colors.green,
                  ),
                  Row(
                    children: [
                      Padding(
                        padding: const EdgeInsets.fromLTRB(8, 0, 8, 0),
                        child: RaisedButton.icon(
                          icon: Icon(Icons.print_rounded),
                          textColor: Colors.white,
                          color: Colors.blue,
                          label: const Text('ພີມໃບບີນ'),
                          onPressed: () {
                            Testprint();
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
                              Navigator.pushReplacement(
                                  context,
                                  MaterialPageRoute(
                                      builder: (context) => Pos()));
                            },
                            color: Colors.green,
                            textColor: Colors.white,
                            child: Row(
                              children: <Widget>[
                                Icon(Icons.update),
                                Text('ສັ່ງຊື້ໃໝ່')
                              ],
                            ),
                          ),
                        ),
                      )
                    ],
                  ),
                ],
              ),
            ),
          ),
        ));
  }
}
