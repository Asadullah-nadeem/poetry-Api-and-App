package in.codeaxe.poetryapp.Models;

public class PoetryModel {
    int id;
    String poet_name;
    String poetry_data;
    String data_time;

    public PoetryModel(int id, String poetry_data, String poet_name, String data_time) {
        this.id = id;
        this.poet_name = poet_name;
        this.poetry_data = poetry_data;
        this.data_time = data_time;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }
    public String getPoet_name() {
        return poet_name;
    }

    public void setPoet_name(String poet_name) {
        this.poet_name = poet_name;
    }

    public String getPoetry_data() {
        return poetry_data;
    }

    public void setPoetry_data(String poetry_data) {
        this.poetry_data = poetry_data;
    }


    public String getData_time() {
        return data_time;
    }

    public void setData_time(String data_time) {
        this.data_time = data_time;
    }
}