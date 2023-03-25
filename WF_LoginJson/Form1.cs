using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Text.RegularExpressions;
using System.Windows.Forms;
using System.Net;
using System.IO;
using System.Web.Script.Serialization;

namespace WF_LoginJson
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();


		}

			private void Form1_Load(object sender, EventArgs e)
        {

        }

        private void btnEntrar_Click(object sender, EventArgs e)
        {
            
        HttpWebRequest request = (HttpWebRequest) WebRequest.Create("https://aluno.etecarmine.com.br/2DS/Camille/Loginconversor/login.php?" + "user=" + txtUsuario.Text + "&pwd=" + txtSenha.Text + "/json/");
        request.AllowAutoRedirect = false;
        HttpWebResponse ChecaServidor = (HttpWebResponse)request.GetResponse();
       
            if (ChecaServidor.StatusCode != HttpStatusCode.OK)
        {
        MessageBox.Show("Erro na requisição: " + ChecaServidor.StatusCode.ToString());
        return; // Encerra o código
        }

        using (Stream webStream = ChecaServidor.GetResponseStream())
         {
         if (webStream != null)
         {
         using (StreamReader responseReader = new StreamReader(webStream))
         {
         
         JavaScriptSerializer serializar = new JavaScriptSerializer();
         String json = responseReader.ReadToEnd();
         json = json.Replace("[","");
         json = json.Replace("]", "");
         MessageBox.Show(json);
         dynamic resultado = serializar.DeserializeObject(json);
         foreach (KeyValuePair<string, object> entry in resultado)
          {
         var key = entry.Key;
         var value = entry.Value as string;
         }

        }
       }
      }

        }
    }
}
