package in.codeaxe.poetryapp.Api;

import in.codeaxe.poetryapp.Response.AddResponse;
import in.codeaxe.poetryapp.Response.DeleteResponse;
import in.codeaxe.poetryapp.Response.GetPoetryResponse;
import in.codeaxe.poetryapp.Response.UpdateResponse;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.POST;

public interface Apiinterface {
    @GET("getpoetry.php")
    Call<GetPoetryResponse> getpoetry();
    @FormUrlEncoded
    @POST("deletepoetry.php")
    Call<DeleteResponse> deletepoetry(@Field("id") String id);


    @FormUrlEncoded
    @POST("addpoetry.php")
    Call<AddResponse>addpoetry(@Field("poetry")String poetryData,
                               @Field("poet_name")String poet_name);
    @FormUrlEncoded
    @POST("updatepoetry.php")
    Call<UpdateResponse>updateresponse(@Field("poetry_data")String poetryData,
                                       @Field("id") String id);
}
