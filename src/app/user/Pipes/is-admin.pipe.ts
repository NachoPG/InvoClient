import { Pipe, PipeTransform } from '@angular/core';

@Pipe({
  name: 'isAdmin',
})
export class IsAdminPipe implements PipeTransform {
  transform(value: string): string {
    return value === '1' ? 'Si' : 'No';
  }
}
