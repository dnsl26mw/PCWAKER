<?php

class SqlGenelator{

    // SELECT文の生成
    public static function SelectQueryGenelator(array $selectColumns, $tableName, array $whereColumns = [], array $signs = []){

        $selectSql = 'SELECT ';

        // SELECT対象のカラム名の連結
        $selectSql .= self::joinColumnName($selectColumns);

        // FROM句とテーブル名の連結
        $selectSql .= ' FROM '.$tableName;

        // WHERE条件の指定がある場合
        if(0 < count($whereColumns)){

            // WHERE条件の連結
            $selectSql .= self::joinWhereCondition($whereColumns, $signs);
        }

        // SELECT文を返す
        return $selectSql;
    }

    // UPDATE文の生成
    public static function UpdateQueryGenelator($tableName, array $updateColumns, array $whereColumns = [], array $signs = []){

        $updateSql = 'UPDATE ';

        // テーブル名とSET句の連結
        $updateSql .= $tableName . ' SET ';

        // UPDATE対象のカラム名の連結
        $updateSql .= self::joinColumnName($updateColumns, true);

        // WHERE条件の指定がある場合
        if(0 < count($whereColumns)){

            // WHERE条件の連結
            $updateSql .= self::joinWhereCondition($whereColumns, $signs);
        }

        // UPDATE文を返す
        return $updateSql;
    }

    // INSERT文の生成
    public static function InsertQueryGenelator($tableName, array $insertColumns){

        $insertSql = 'INSERT INTO ';

        // テーブル名、'('の連結
        $insertSql .= $tableName . '(';

        // カラム名の連結
        $insertSql .= self::joinColumnName($insertColumns);

        // ')'の連結
        $insertSql .= ')';

        // VALUES句の連結
        $insertSql .= ' VALUES(';

        for($i = 0; $i < count($insertColumns); $i++){

            $insertSql .= '?';

            if($i < count($insertColumns)-1){

                // ','の連結
                $insertSql .= ', ';
            }
            else{

                // ')'の連結
                $insertSql .= ')';
            }
        }

        // INSERT文を返す
        return $insertSql;
    }

    // DELETE文の生成
    public static function DeleteQueryGenelator($tableName, array $whereColumns = [], array $signs = []){

        $deleteSql = 'DELETE FROM ';

        // テーブル名の連結
        $deleteSql .= $tableName . ' ';

        // WHERE条件の指定がある場合
        if(0 < count($whereColumns)){

            // WHERE条件の連結
            $deleteSql .= self::joinWhereCondition($whereColumns, $signs);
        }

        // DELETE文を返す
        return $deleteSql;
    }

    // カラム名の連結
    private static function joinColumnName(array $columns, $updateFlg = false){

        $retStr = '';

        for($i = 0; $i < count($columns); $i++){

            $retStr .= $columns[$i];

            // UPDATE文生成の場合
            if($updateFlg){

                $retStr.='=?';
            }

            if($i < count($columns)-1){

                $retStr.=', ';
            }
        }

        return $retStr;
    }

    // WHERE条件の連結
    private static function joinWhereCondition(array $whereColumns, array $signs = []){

        $retStr = ' WHERE ';

        for($i = 0; $i < count($whereColumns); $i++){

            $retStr.=$whereColumns[$i] . '=?';

            if(0 < count($signs)){

                $retStr.= ' ' . $signs[$i] . ' ';
            }

        }

        return $retStr;
    }

}

?>