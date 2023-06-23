package in.codeaxe.poetryapp;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.AppCompatButton;
import androidx.appcompat.widget.Toolbar;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import in.codeaxe.poetryapp.Api.ApiClient;
import in.codeaxe.poetryapp.Api.Apiinterface;
import in.codeaxe.poetryapp.Response.AddResponse;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;

public class AddPoetry extends AppCompatActivity {

    Toolbar toolbar;
    EditText poetname, poetryData;
    AppCompatButton submitBtn;

    Apiinterface apiinterface;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_add_poetry);
        initialization();
        setuptoolbar();

        submitBtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String poetryDataString = poetryData
                        .getText()
                        .toString();
                String poetryNameString = poetname
                        .getText()
                        .toString();

                if (poetryDataString.equals("")){
                    poetryData.setError("Field is empty");

                } else if (poetryNameString.equals("")) {
                    poetname.setError("Field is Empty");
                } else {
                    callapi(poetryDataString,poetryNameString);
                }

            }
        });
    }
    private void initialization(){
        toolbar = findViewById(R.id.add_pretry_toolbar);
        poetname = findViewById(R.id.add_Poetry_name_edittext);
        poetryData = findViewById(R.id.add_Poetry_Data_edittext );
        submitBtn =findViewById(R.id.submit_data_btn);
        Retrofit retrofit = ApiClient.getclient();
        apiinterface = retrofit.create(Apiinterface.class);
    }
    private void setuptoolbar(){
        setSupportActionBar(toolbar);
        getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        toolbar.setNavigationOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                finish();
            }
        });
    }
    private void callapi(String poetryData, String poet_name){

        apiinterface
                .addpoetry(poetryData, poet_name)
                .enqueue(new Callback<AddResponse>() {
            @Override
            public void onResponse(Call<AddResponse> call, Response<AddResponse> response) {

                try {
                    if (response.body().getStatus().equals("1")){
                        Toast.makeText(AddPoetry.this, "Add Succesfully", Toast.LENGTH_SHORT).show();

                    }else {
                        Toast.makeText(AddPoetry.this, "Add Not Succesfully", Toast.LENGTH_SHORT).show();
                    }

                }catch (Exception e){
                    Log.e("exp", e.getLocalizedMessage());
                }
            }

            @Override
            public void onFailure(Call<AddResponse> call, Throwable t) {
                Log.e("failure", t.getLocalizedMessage());
            }
        });
    }
}