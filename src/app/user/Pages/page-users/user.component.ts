import { Component, OnInit } from '@angular/core';
import { User } from '../../Intefaces/user.interface';
import { UserData } from '../../Intefaces/userData.interface';
import { AdminService } from '../../Services/admin.service';

@Component({
  selector: 'app-user',
  templateUrl: './user.component.html',
  styleUrls: ['./user.component.css'],
})
export class UserComponent implements OnInit {
  usersData: UserData[] = [];
  errorDelete: boolean = false;
  errorCreate: boolean = false;
  constructor(private adminService: AdminService) {}

  ngOnInit(): void {
    this.getAllUsers();
  }

  getAllUsers() {
    this.adminService.getAllUsers().subscribe({
      next: (response) => (this.usersData = response),
      error: (err) => console.log(err),
    });
  }

  deleteUser(id: string) {
    this.adminService.deleteUserById(id).subscribe({
      next: () => {
        this.errorDelete = false;
        this.ngOnInit();
      },
      error: () => {
        this.errorDelete = true;
      },
    });
  }

  createUser(user: User) {
    this.adminService.createUser(user).subscribe({
      next: () => {
        this.errorCreate = false;
        this.ngOnInit();
      },
      error: (err) => {
        this.errorCreate = true;
        console.log(err);
      },
    });
  }
}
