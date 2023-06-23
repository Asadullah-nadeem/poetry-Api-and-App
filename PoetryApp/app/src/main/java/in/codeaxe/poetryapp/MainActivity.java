package in.codeaxe.poetryapp;

import androidx.annotation.NonNull;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.recyclerview.widget.LinearLayoutManager;
import androidx.recyclerview.widget.RecyclerView;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.Toast;

import java.util.ArrayList;
import java.util.List;

import in.codeaxe.poetryapp.Adapter.PoetryAdapter;
import in.codeaxe.poetryapp.Api.ApiClient;
import in.codeaxe.poetryapp.Api.Apiinterface;
import in.codeaxe.poetryapp.Models.PoetryModel;
import in.codeaxe.poetryapp.Response.GetPoetryResponse;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;

public class MainActivity extends AppCompatActivity {
    RecyclerView recyclerView;
    PoetryAdapter poetryAdapter;
    Apiinterface apiinterface;
    ProgressBar progressBar;

    Toolbar toolbar;

    List<PoetryModel> poetryModelList = new ArrayList<>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        initialization();
        setSupportActionBar(toolbar);
        getData();
    }

    private void initialization() {
        recyclerView = findViewById(R.id.poetry_recyclerview);
        Retrofit retrofit = ApiClient.getclient();
        apiinterface = retrofit.create(Apiinterface.class);
        toolbar = findViewById(R.id.main_toolbar);
        progressBar = findViewById(R.id.progressBar);

    }

    private void setAdapter(List<PoetryModel> poetryModels) {
        poetryAdapter = new PoetryAdapter(this, poetryModels);
        LinearLayoutManager linearLayoutManager = new LinearLayoutManager(this);
        recyclerView.setLayoutManager(linearLayoutManager);
        recyclerView.setAdapter(poetryAdapter);
    }

    private void showProgressBar() {
        progressBar.setVisibility(View.VISIBLE);
    }

    private void hideProgressBar() {
        progressBar.setVisibility(View.GONE);
    }

    private void getData() {
        showProgressBar();

        apiinterface.getpoetry().enqueue(new Callback<GetPoetryResponse>() {
            @Override
            public void onResponse(Call<GetPoetryResponse> call, Response<GetPoetryResponse> response) {
                hideProgressBar(); // Hide ProgressBar after the API response

                try {
                    if (response != null) {
                        if (response.body().getStatus().equals("1")) {
                            poetryModelList = response.body().getData(); // Update the poetryModelList
                            setAdapter(poetryModelList);
                        } else {
                            Toast.makeText(MainActivity.this, response.body().getMessage(), Toast.LENGTH_SHORT).show();
                        }
                    }
                } catch (Exception e) {
                    Log.e("exp", e.getLocalizedMessage());
                }
            }

            @Override
            public void onFailure(Call<GetPoetryResponse> call, Throwable t) {
                hideProgressBar(); // Hide ProgressBar on API call failure
                Log.e("failure", t.getLocalizedMessage());
            }
        });
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.toolbar_menu, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(@NonNull MenuItem item) {
        if (item.getItemId() == R.id.add_property) {
            Intent x = new Intent(MainActivity.this, AddPoetry.class);
            startActivity(x);
            return true;
        } else if (item.getItemId() == R.id.refreshbtn) {
            refreshData();
            return true;
        }
        return super.onOptionsItemSelected(item);
    }

    private void refreshData() {
        getData(); // Call the API again to fetch updated data
    }
}
