package in.codeaxe.poetryapp.Response;

import java.util.List;

import in.codeaxe.poetryapp.Adapter.PoetryAdapter;
import in.codeaxe.poetryapp.Models.PoetryModel;

public class GetPoetryResponse {

    String status;
    String message;
    List <PoetryModel> data;

    public GetPoetryResponse(String status, String message, List<PoetryModel> data) {
        this.status = status;
        this.message = message;
        this.data = data;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }

    public List<PoetryModel> getData() {
        return data;
    }

    public void setData(List<PoetryModel> data) {
        this.data = data;
    }
}
