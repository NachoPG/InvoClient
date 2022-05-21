import { Pipe, PipeTransform } from '@angular/core';
import { UserData } from '../Intefaces/userData.interface';

@Pipe({
  name: 'searchFilterUsers',
})
export class SearchFilterUsersPipe implements PipeTransform {
  transform(listUsers: UserData[], searchValue: string): UserData[] {
    if (!listUsers || !searchValue) {
      return listUsers;
    }

    return listUsers.filter(
      (user) =>
        user.idUser.toLowerCase().includes(searchValue.toLowerCase()) ||
        user.name.toLowerCase().includes(searchValue.toLowerCase()) ||
        user.surname.toLowerCase().includes(searchValue.toLowerCase()) ||
        user.username.toLowerCase().includes(searchValue.toLowerCase())
    );
  }
}
