package in.codeaxe.poetryapp;

import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.AppCompatButton;

import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.EditText;
import android.widget.Toast;

import androidx.appcompat.widget.Toolbar;

import in.codeaxe.poetryapp.Api.ApiClient;
import in.codeaxe.poetryapp.Api.Apiinterface;
import in.codeaxe.poetryapp.Response.UpdateResponse;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;

public class UpdatePoetry extends AppCompatActivity {
    Toolbar toolbar;
    EditText editText;
    AppCompatButton sumitbtn;

    int poetryId;
    String pdata;
    Apiinterface apiinterface;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_update_poetry);
        intialization();
        setuptoolbar();
        sumitbtn.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                String p_data = editText.getText().toString();
                if (p_data.equals("")){
                   editText.setError("Field is empty");
                }else {
                    callapi(p_data, poetryId+"");
                }
            }
        });

    }
    private void intialization(){
        toolbar = findViewById(R.id.update_pretry_toolbar);
        editText = findViewById(R.id.update_Poetry_Data_edittext);
        sumitbtn = findViewById(R.id.update_submit_data_btn);

        poetryId = getIntent().getIntExtra("p_id" ,0);
        pdata = getIntent().getStringExtra("p_data" );
        editText.setText(pdata);

        Retrofit retrofit = ApiClient.getclient();
         apiinterface = retrofit.create(Apiinterface.class);
    }
//    back button
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
    private void callapi(String pdata, String pid){
        apiinterface.updateresponse(pdata,pid).enqueue(new Callback<UpdateResponse>() {
            @Override
            public void onResponse(Call<UpdateResponse> call, Response<UpdateResponse> response) {

                try {
                    if (response.body().getStatus().equals("1")){
                        Toast.makeText(UpdatePoetry.this, "Data Update", Toast.LENGTH_SHORT).show();
                    }else {
                        Toast.makeText(UpdatePoetry.this, "Data not Update", Toast.LENGTH_SHORT).show();
                    }
                }catch (Exception e){
                    Log.e("updatefail", e.getLocalizedMessage());
                }
            }

            @Override
            public void onFailure(Call<UpdateResponse> call, Throwable t) {
                Log.e("updatefail", t.getLocalizedMessage());
            }
        });
    }

}