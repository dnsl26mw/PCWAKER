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
    public static function UpdateQueryGenelator(){

        $updateSql = 'UPDATE ';
        
        // SET句の付加
        $updateSql .= ' SET ';

        return $updateSql;
    }

    // INSERT文の生成
    public static function InsertQueryGenelator(){

        $insertSql = 'INSERT INTO ';

        // VALUES句の付加
        $insertSql .= ' VALUES(';

        return $insertSql;
    }

    // DELETE文の生成
    public static function DeleteQueryGenelator(){

        $deleteSql = 'DELETE FROM ';

        return $deleteSql;
    }

    // カラム名の連結
    private static function joinColumnName(array $columns){

        $retStr = '';

        for($i = 0; $i < count($columns); $i++){

            $retStr = $retStr.=$columns[$i];

            if($i < count($columns)-1){

                $retStr = $retStr.=', ';

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