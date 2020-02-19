import { Component, OnInit } from '@angular/core';
import {User} from '../../models/user';
import {UserService} from '../../services/user.service';

//crear objeto de tipo usuario para rellenar el formulario

@Component({
  selector: 'app-register',
  templateUrl: './register.component.html',
  styleUrls: ['./register.component.css'],
  providers: [UserService],
})
export class RegisterComponent implements OnInit {

	public page_title:string;
  public user: User;
  public status:string;

  constructor(
  private _UserService: UserService
    ) {
     this.page_title = 'Registrate';
     this.user = new User(1,'','','ROLE_USER','','','','');
   }

  ngOnInit() {
  	console.log('Componente de registro lanzado!!');
    console.log(this._UserService.test());
  }
  //componente declarado en el formulario el onSubmit
  onSubmit(form){
    this._UserService.register(this.user).subscribe(
          response =>{
           if(response.status == "success"){
            this.status = response.status;
//vacío el formulario
            form.reset();

           }else {
            this.status = 'error';
           }

               form.reset();
          },
          error => {
            this.status = 'error';
            console.log (<any>error);
          }
      );
    console.log(this.user);
 
  }

}
