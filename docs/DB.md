

## シート: user

|   Unnamed: 0 | user(ユーザー)テーブル   | Unnamed: 2   | Unnamed: 3    | Unnamed: 4   |   Unnamed: 5 | Unnamed: 6                 |
|-------------:|:-------------------------|:-------------|:--------------|:-------------|-------------:|:---------------------------|
|          nan | 表示名                   | 伦理名       | 物理名        | 桁数         |          nan | 说明                       |
|            1 | ユーザーID               | user ID      | id            | —            |          nan | 主キー、自動採番           |
|            2 | ユーザー名               | username     | username      | 50           |          nan | ユーザーの表示名           |
|            3 | メール                   | email        | email         | 100          |          nan | ログイン用メールアドレス   |
|            4 | パスワード               | password     | password_hash | 255          |          nan | ハッシュ化されたパスワード |
|            5 | 登録日時                 | created date | created_at    | —            |          nan | ユーザーの登録日時         |

---

## シート: products

|   Unnamed: 0 | products テーブル構造（商品テーブル结构）   | Unnamed: 2       |   Unnamed: 3 | Unnamed: 4     |   Unnamed: 5 | Unnamed: 6   |   Unnamed: 7 | Unnamed: 8                           |
|-------------:|:--------------------------------------------|:-----------------|-------------:|:---------------|-------------:|:-------------|-------------:|:-------------------------------------|
|          nan | 表示名                                      | 字段名（物理名） |          nan | 型（类型）     |          nan | 桁数 / 精度  |          nan | 说明（备注）                         |
|            1 | 商品ID                                      | id               |          nan | int(11)        |          nan | -            |          nan | 主キー、自動採番（AUTO_INCREMENT）   |
|            2 | 商品名                                      | name             |          nan | varchar        |          nan | 255          |          nan | 商品の名前                           |
|            3 | 価格                                        | price            |          nan | decimal(10, 2) |          nan | 小数2桁      |          nan | 商品の価格                           |
|            4 | 商品画像URL                                 | image_url        |          nan | varchar        |          nan | 255          |          nan | 商品画像のパス、NULL可               |
|            5 | 商品説明                                    | description      |          nan | text           |          nan | -            |          nan | 商品の詳細説明、NULL可               |
|            6 | 在庫数                                      | stock            |          nan | int(11)        |          nan | -            |          nan | 商品の在庫数、デフォルトは0          |
|            7 | 登録日時                                    | created_at       |          nan | timestamp      |          nan | -            |          nan | 商品の登録日時、デフォルトは現在時刻 |
|            8 | おすすめフラグ                              | is_recommended   |          nan | tinyint(1)     |          nan | -            |          nan | おすすめ商品かどうか（0: 否、1: 是） |

---

## シート: cart

|   Unnamed: 0 | cart テーブル構造（カートテーブル结构）   | Unnamed: 2       |   Unnamed: 3 | Unnamed: 4   |   Unnamed: 5 | Unnamed: 6   |   Unnamed: 7 | Unnamed: 8                                                |
|-------------:|:------------------------------------------|:-----------------|-------------:|:-------------|-------------:|:-------------|-------------:|:----------------------------------------------------------|
|          nan | 表示名                                    | 字段名（物理名） |          nan | 型（类型）   |          nan | 桁数 / 精度  |          nan | 说明（备注）                                              |
|            1 | カートID                                  | id               |          nan | int(11)      |          nan | -            |          nan | 主キー、自動採番（AUTO_INCREMENT）                        |
|            2 | ユーザーID                                | user_id          |          nan | int(11)      |          nan | -            |          nan | ユーザーテーブル（users）への外部キー                     |
|            3 | 商品ID                                    | product_id       |          nan | int(11)      |          nan | -            |          nan | 商品テーブル（products）への外部キー                      |
|            4 | 数量                                      | quantity         |          nan | int(11)      |          nan | -            |          nan | 購入する商品の数量、デフォルトは 1                        |
|            5 | 登録日時                                  | created_at       |          nan | datetime     |          nan | -            |          nan | レコード作成日時、デフォルトは現在時刻                    |
|            6 | 更新日時                                  | updated_at       |          nan | datetime     |          nan | -            |          nan | レコード更新日時、自動更新（ON UPDATE CURRENT_TIMESTAMP） |

---

## シート: order_items

| order_items テーブル構造（注文商品テーブル结构）   | Unnamed: 1   | Unnamed: 2       | Unnamed: 3   | Unnamed: 4   | Unnamed: 5                                                |
|:---------------------------------------------------|:-------------|:-----------------|:-------------|:-------------|:----------------------------------------------------------|
| nan                                                | nan          | nan              | nan          | nan          | nan                                                       |
|                                                    | 表示名       | 字段名（物理名） | 型（类型）   | 桁数 / 精度  | 说明（备注）                                              |
| 1                                                  | 注文項目ID   | id               | int(11)      | -            | 主キー、自動採番（AUTO_INCREMENT）                        |
| 2                                                  | ユーザーID   | user_id          | int(11)      | -            | ユーザーテーブル（users）への外部キー                     |
| 3                                                  | 商品ID       | product_id       | int(11)      | -            | 商品テーブル（products）への外部キー                      |
| 4                                                  | 数量         | quantity         | int(11)      | -            | 注文された商品の数量、デフォルトは 1                      |
| 5                                                  | 登録日時     | created_at       | datetime     | -            | レコード作成日時、デフォルトは現在時刻                    |
| 6                                                  | 更新日時     | updated_at       | datetime     | -            | レコード更新日時、自動更新（ON UPDATE CURRENT_TIMESTAMP） |

---

## シート: orders

| orders テーブル構造（注文テーブル结构）   | Unnamed: 1     | Unnamed: 2       | Unnamed: 3    | Unnamed: 4   | Unnamed: 5                                                  |
|:------------------------------------------|:---------------|:-----------------|:--------------|:-------------|:------------------------------------------------------------|
| 番号                                      | 表示名         | 字段名（物理名） | 型（类型）    | 桁数 / 精度  | 说明（备注）                                                |
| 1                                         | 注文ID         | id               | int(11)       | -            | 主キー、自動採番（AUTO_INCREMENT）                          |
| 2                                         | ユーザーID     | user_id          | int(11)       | -            | ユーザーテーブル（users）への外部キー、NULL可               |
| 3                                         | 合計金額       | total            | decimal(10,2) | 小数2桁      | 合計金額、NULL可（後で計算されるケース）                    |
| 4                                         | 注文ステータス | status           | varchar(10)   | 10           | 状態（例：pending、paid、shipped 等）、デフォルトは pending |
| 5                                         | 登録日時       | created_at       | timestamp     | -            | レコード作成日時、デフォルトは現在時刻                      |

---

## シート: cart_item

| cart_item テーブル構造（カート項目テーブル结构）   |   Unnamed: 1 | Unnamed: 2   |   Unnamed: 3 | Unnamed: 4       |   Unnamed: 5 | Unnamed: 6   |   Unnamed: 7 | Unnamed: 8   |   Unnamed: 9 | Unnamed: 10                                               |
|:---------------------------------------------------|-------------:|:-------------|-------------:|:-----------------|-------------:|:-------------|-------------:|:-------------|-------------:|:----------------------------------------------------------|
| 番号                                               |          nan | 表示名       |          nan | 字段名（物理名） |          nan | 型（类型）   |          nan | 桁数 / 精度  |          nan | 说明（备注）                                              |
| 1                                                  |          nan | カート項目ID |          nan | id               |          nan | int(11)      |          nan | -            |          nan | 主キー、自動採番（AUTO_INCREMENT）                        |
| 2                                                  |          nan | ユーザーID   |          nan | user_id          |          nan | int(11)      |          nan | -            |          nan | ユーザーテーブル（users）への外部キー                     |
| 3                                                  |          nan | 商品ID       |          nan | product_id       |          nan | int(11)      |          nan | -            |          nan | 商品テーブル（products）への外部キー                      |
| 4                                                  |          nan | 数量         |          nan | quantity         |          nan | int(11)      |          nan | -            |          nan | 購入する商品の数量、デフォルトは 1                        |
| 5                                                  |          nan | 登録日時     |          nan | created_at       |          nan | datetime     |          nan | -            |          nan | レコード作成日時、デフォルトは現在時刻                    |
| 6                                                  |          nan | 更新日時     |          nan | updated_at       |          nan | datetime     |          nan | -            |          nan | レコード更新日時、自動更新（ON UPDATE CURRENT_TIMESTAMP） |

