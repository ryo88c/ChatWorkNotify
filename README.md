# ChatWork Notify

チャットワークの未読を SMS で確認。

## How to use

1. アプリケーションを任意のサーバに設置
2. チャットワークに API の利用を申請
3. Globe labs で API の利用申請
4. Globe labs でアプリケーションの新規作成
5. 作成したアプリケーションの認証ダイアログから対象とする電話番号を送信
6. 送信した電話番号宛に送られる SMS に書かれた認証コードを入力
7. 1 で作成したアプリケーションにリダイレクトし、ステータスコード 200 が返ってくれば登録完了
8. 4 で作成したアプリケーションの Shortcode 宛に unread と SMS を送信
9. チャットワークの未読が返ってくる


### Globe Labs

http://www.globelabs.com.ph/docs

### Application page

https://developer.globelabs.com.ph/apps/rxbGuo9RyeHzaiX786cR65HnqxxnubMB

### API document

https://docs.google.com/document/d/1xQYPFsWSnHY9htIYNL2bENLok8rbAgzxdXsFWbSwE80/pub?embedded=true

### Authentication dialog

http://developer.globelabs.com.ph/dialog/oauth?app_id=rxbGuo9RyeHzaiX786cR65HnqxxnubMB

### ChatWork

http://developer.chatwork.com/ja/authenticate.html