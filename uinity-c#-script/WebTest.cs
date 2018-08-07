using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class WebTest : MonoBehaviour
{

    // Use this for initialization
    IEnumerator Start()
    {
        WWW request = new WWW("http://localhost/sqlconnect/webtest.php");
        yield return request;
        //Debug.Log(request.text);
        string[] webResults = request.text.Split('|');
        foreach (string s in webResults)
        {
            Debug.Log(s);
        }
        Debug.Log("first word:" + webResults[0]);
        int webNum = int.Parse(webResults[2]); //parsing array
        webNum *= 2;
        Debug.Log(webNum);
    }


}
